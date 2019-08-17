<?php


namespace App\Core\Exceptions;


use RuntimeException;

/**
 * Class BusinessException
 * @package App\Exceptions
 */
class BusinessException extends RuntimeException
{

    /**
     * <b>Mensagem:</b><i> Erro ao realizar operação.</i>
     *
     * @var string
     */
    const GENERIC_ERROR = 'generic_error';

    /**
     * <b>Mensagem:</b><i> Erro ao salvar %s.</i>
     *
     * @var string
     */
    const ERROR_CREATE = 'error_create';

    /**
     * <b>Mensagem:</b><i> Erro ao recuperar %s.</i>
     *
     * @var string
     */
    const ERROR_READ = 'error_read';

    /**
     * <b>Mensagem:</b><i> Erro ao alterar %s.</i>
     *
     * @var string
     */
    const ERROR_UPDATE = 'error_update';

    /**
     * <b>Mensagem:</b><i> Erro ao remover %s.</i>
     *
     * @var string
     */
    const ERROR_DELETE = 'error_delete';

    /**
     * <b>Mensagem:</b><i> Não foi possível encontrar %s para o parâmetro informado.</i>
     *
     * @var string
     */
    const INVALID_ID = 'invalid_id';

    /**
     * <b>Mensagem:</b><i> Valor inválido para o parâmetro %s.</i>
     *
     * @var string
     */
    const INVALID_PARAM = 'invalid_param';

    /**
     * <b>Mensagem:</b><i> Não foi possível processar a entidade %s.</i>
     *
     * @var string
     */
    const UNPROCESSABLE_ENTITY = 'unprocessable_entity';

    /**
     * <b>Mensagem:</b><i> %s não possui a propriedade %s definida.</i>
     *
     * @var string
     */
    const UNDEFINED_PROPERTY = 'undefined_property';

    /**
     * <b>Mensagem:</b><i> %s.</i>
     *
     * @var string
     */
    const CUSTOMIZED = 'customized';

    /**
     * @var array
     */
    public static $messages = array(
        self::GENERIC_ERROR => "Erro ao realizar operação %s",
        self::ERROR_CREATE => "Erro ao salvar %s",
        self::ERROR_READ => "Erro ao recuperar %s",
        self::ERROR_UPDATE => "Erro ao alterar %s",
        self::ERROR_DELETE => "Erro ao remover %s",
        self::INVALID_ID => 'Não foi possível encontrar %s para o parâmetro informado',
        self::INVALID_PARAM => 'Valor inválido para o parâmetro %s',
        self::UNPROCESSABLE_ENTITY => "Não foi possível processar a entidade %s",
        self::UNDEFINED_PROPERTY => '%s não possui a propriedade %s definida',
        self::CUSTOMIZED => "%s"
    );
    private static $mode;
    private $title;

    /**
     * BusinessException constructor.
     * @param $strMessage
     * @param null $mixArgs
     * @param int $intCode
     */
    public function __construct(
        $strMessage,
        $mixArgs = null,
        $intCode = 412
    )
    {
        $strConfMessage = self::$messages[$strMessage];

        if (!is_null($mixArgs) & !is_array($mixArgs)) {
            $mixArgs = array($mixArgs);
        }

        $this->setTitle(__CLASS__);

        $strFormatedMessage = vsprintf($strConfMessage, $mixArgs);
        $strFormatedMessage = trim($strFormatedMessage) . '.';

        parent::__construct($strFormatedMessage, $intCode);
    }

    /**
     *
     * @param string $strKeyMessage
     * @param string|array $mixComplement
     * @return string
     */
    public static function getMessageByKey($strKeyMessage, $mixComplement = null)
    {
        $strMessage = self::getMessages()[$strKeyMessage];

        if (!is_null($mixComplement)) {
            if (is_array($mixComplement)) {
                $strMessage = vsprintf($strMessage, $mixComplement);
            } else {
                $strMessage = vsprintf($strMessage, array($mixComplement));
            }
        }
        $strMessage = str_ireplace(' %s', '', $strMessage);

        return trim($strMessage) . '.';
    }

    /**
     * @return array
     */
    public static function getMessages()
    {
        return self::$messages;
    }

    /**
     * @param $strMode
     */
    public static function setMode($strMode)
    {
        self::$mode = $strMode;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return 'BACKEND-ERROR.' . get_class($this) . '.' . $this->getCode();
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $strTitle Título da exception
     * @return $this
     */
    public function setTitle($strTitle)
    {
        $this->title = $strTitle;
        return $this;
    }
}
