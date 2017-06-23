<?php
/**
 * TranslationExtension adds a translate function for twig templates in a slim framework application.
 *
 * TranslationExtension expects an instance of a translator class injected into the slim app and tries
 * to call the "trans()" function on the translator class.
 *
 * Example usage:
 * {{ translate('male') }}
 * {{ tans('male') }}
 * {{ _('male') }}
 *
 */

namespace Luna\Translation;

use Illuminate\Translation\Translator;

/**
 * Registers the Illuminate Translator as a the trans and transChoice functions in Twig
 */
class TranslationExtension extends \Twig_Extension
{
    /**
     * @var Translator
     */
    private $translator;

    public function __construct(Translator $translator)
    {
        $this->translator = $translator;
    }

    public function getName()
    {
        return 'microcms_translator';
    }

    public function getFunctions()
    {
        return [
            new \Twig_SimpleFunction('translate', array($this->translator, 'trans')),
            new \Twig_SimpleFunction('trans', array($this->translator, 'trans')),
            new \Twig_SimpleFunction('__', array($this->translator, 'trans')),
            new \Twig_SimpleFunction('trans_choice', array($this->translator, 'trans_choice')),
        ];
    }
}