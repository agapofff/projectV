<?php

namespace app\services\lang;

use app\entities\lang\LangTranslation;
use app\repositories\LangRepository;
use app\repositories\LangTranslationRepository;
use app\repositories\LangTranslatorRepository;
use Symfony\Component\Finder\Finder;
use yii\helpers\FileHelper;
use yii\helpers\Url;

class LangTranslationService
{
    private $langRepository;
    private $langTranslatorRepository;
    private $langTranslationRepository;

    public function __construct(
        LangRepository $langRepository,
        LangTranslatorRepository $langTranslatorRepository,
        LangTranslationRepository $langTranslationRepository
    )
    {
        $this->langRepository = $langRepository;
        $this->langTranslatorRepository = $langTranslatorRepository;
        $this->langTranslationRepository = $langTranslationRepository;
    }

    public function checkAccess(
        string $locale_to,
        int $user_id,
        bool $is_admin
    ): bool
    {
        if ($is_admin) {
            return true;
        }

        $language = $this->langRepository->getByLocale($locale_to);

        if ($this->langTranslatorRepository->getByLangIdAndUserId($user_id, $language->id)) {
            return true;
        }
    }

    public function update(
        int $id,
        string $locale,
        string $message
    )
    {
        $language_translation = $this->langTranslationRepository->get($id);
        $language_translation->editMessage(
            $locale,
            $message
        );
        $this->langTranslationRepository->save($language_translation);

        $this->export($locale);

        return $language_translation;
    }

    public function delete(int $id)
    {
        $this->langTranslationRepository->remove($id);
    }

    public function messagesOnline($category)
    {
        $path = Url::to('@app');
        $messages = [];

        $stringPattern =
            "[^\w]".                                        // Must not have an alphanumeric before real method
            'Yii::t'.                                       // Must start with one of the functions
            "\(\s*".                                        // Match opening parenthesis
            "'$category', (?P<quote>['\"])".                      // Match " or ' and store in {quote}
            "(?P<string>(?:\\\k{quote}|(?!\k{quote}).)*)".  // Match any string that can be {quote} escaped
            "\k{quote}".                                    // Match " or ' previously matched
            "\s*[\),]";                                     // Close parentheses or new parameter

        // Find all PHP + Twig files in the app folder, except for storage
        $finder = new Finder();
        $finder->in($path)
            ->exclude(['assets', 'auth', 'messages', 'runtime', 'vendor', 'web'])
            ->name('*.php')
            ->files();

        foreach ($finder as $file) {
            if (!preg_match("(views/auth|views/news/form|admin.php|Country.php|Lang.php|Ticket.php)", $file->getRelativePathname())) {
                if (preg_match("(Yii::t)", $file->getContents())) {
                    if (preg_match_all("/$stringPattern/siU", $file->getContents(), $matches)) {
                        foreach ($matches['string'] as $key) {
                            $messages[] = $key;
                        }
                    }
                }
            }
        }

        $messages = array_unique($messages);

        sort($messages);

        return $messages;
    }

    public function messages()
    {
        $path = Url::to('@app');
        $messages = [];

        $stringPattern =
            "[^\w]".                                        // Must not have an alphanumeric before real method
            'Yii::t'.                                       // Must start with one of the functions
            "\(\s*".                                        // Match opening parenthesis
            "'app', (?P<quote>['\"])".                      // Match " or ' and store in {quote}
            "(?P<string>(?:\\\k{quote}|(?!\k{quote}).)*)".  // Match any string that can be {quote} escaped
            "\k{quote}".                                    // Match " or ' previously matched
            "\s*[\),]";                                     // Close parentheses or new parameter

        // Find all PHP + Twig files in the app folder, except for storage
        $finder = new Finder();
        $finder->in($path)
            ->exclude(['assets','auth','components','config','messages','repositories','runtime','vendor','web'])
            ->name('*.php')
            ->files();

        foreach ($finder as $file) {
            if (!preg_match("(views/auth|views/news/form|admin|admin.php|Country.php|Lang.php|Ticket.php)", $file->getRelativePathname())) {
                if (preg_match("(Yii::t)", $file->getContents())) {
                    if (preg_match_all("/$stringPattern/siU", $file->getContents(), $matches)) {
                        foreach ($matches['string'] as $key) {
                            $messages[] = $key;
                        }
                    }
                }
            }
        }

        $messages = array_unique($messages);

        sort($messages);

        $this->langTranslationRepository->updateInactive();
        foreach ($messages as $message) {
            if ($this->langTranslationRepository->checkMessage($message) == 0) {
                $langTranslation = LangTranslation::create($message, 1);
                $this->langTranslationRepository->save($langTranslation);
            } else {
                $this->langTranslationRepository->updateActive($message);
            }
        }
    }

    public function export(string $locale)
    {
        $language_translations = $this->langTranslationRepository->getAll();
        $messages = [];
        foreach ($language_translations as $language_translation) {
            $message_to = $language_translation->getMessage($locale);

            $from = str_replace('"', '\"', $language_translation->ru_ru);
            $to = str_replace('"', '\"', $language_translation->$message_to);

            if (!empty($to)) {
                $messages[] = '"' . $from . '" => "' . $to . '",';
            }
        }

        $content = '<?php' . PHP_EOL . PHP_EOL;
        $content .= 'return [' . PHP_EOL;
        $content .= implode(PHP_EOL, $messages) . PHP_EOL;
        $content .= '];' . PHP_EOL;

        $directory = LangTranslation::getLinkToDirectory($locale);
        if (!is_dir($directory)) {
            FileHelper::createDirectory($directory);
        }

        $file = LangTranslation::getLinkToFile($locale);
        $fp = fopen($file, "w+");
        fwrite($fp, $content);
        fclose($fp);
    }
}
