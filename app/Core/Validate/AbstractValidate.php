<?php


namespace App\Core\Validate;


use App\Core\Exceptions\BusinessException;
use App\Core\Traits\UtilsTrait as U;
use Illuminate\Support\Facades\Validator;

abstract class AbstractValidate
{
    use U;

    /**
     * @param null $mixValue
     */
    public function validarUuid($mixValue = null): void
    {
        if (Validator::make(['uuid' => $mixValue], ['uuid' => 'uuid'])->fails()) {
            throw new BusinessException(BusinessException::INVALID_ID, 'registro');
        }
    }

    /**
     * @param null $mixValue
     */
    public function validarFind($mixValue = null): void
    {
        if (empty(reset($mixValue))) {
            throw new BusinessException(BusinessException::INVALID_ID, 'registro');
        }
    }

    /**
     * @param $arrParams
     * @param string $strEntidade Entidade onde deve se verificar se já possui o CPF cadastrado
     * @param string $strIdExcecao Identificador Primario que deve ser desconsiderado com validacao de exclusividade
     *                             Por exemplo: ao alterar o nome de um cliente mantendo o mesmo CPF, este não deve
     *                             se submeter a validação de UNIQUE
     */
    public function validarCpf(array $arrParams, string $strEntidade, $strIdExcecao = ''): void
    {
        if (Validator::make($arrParams,
                ['co_cpf' => 'nullable|string|max:11|min:11'])->fails() ||
            $this->isCpfInvalido($arrParams)
        ) {
            throw new BusinessException(BusinessException::INVALID_PARAM, 'CPF');
        }
    }

    /**
     * @param array $arrParams
     * @param string $strEntidade Entidade onde deve se verificar se já possui o CNPJ cadastrado
     * @param string $strIdExcecao Identificador Primario que deve ser desconsiderado com validacao de exclusividade
     *                             Por exemplo: ao alterar o nome de um funcionário mantendo o mesmo CNPJ, este não deve
     *                             se submeter a validação de UNIQUE
     */
    public function validarCnpj(array $arrParams, string $strEntidade, $strIdExcecao = ''): void
    {
        $this->validarCnpjUnico($arrParams, $strEntidade, $strIdExcecao);
        if (Validator::make($arrParams,
                ['co_cnpj' => 'nullable|string|max:14|min:14'])->fails() ||
            $this->isCnpjInvalido($arrParams)
        ) {
            throw new BusinessException(BusinessException::INVALID_PARAM, 'CNPJ');
        }
    }

    /**
     * @param $arrParams
     * @param $strEntidade
     * @param string $strIdExcecao
     */
    public function validarCpfUnico(array $arrParams, string $strEntidade, $strIdExcecao = ''): void
    {
        if (Validator::make($arrParams,
            ['co_cpf' => 'unique:' . $strEntidade . ',co_cpf' . $this->getExcept($strEntidade, $strIdExcecao)])->fails()
        ) {
            throw new BusinessException(
                BusinessException::CUSTOMIZED, 'Já existe um cadastro vinculado à este CPF'
            );
        }
    }

    /**
     * @param $arrParams
     * @param $strEntidade
     * @param string $strIdExcecao
     */
    private function validarCnpjUnico($arrParams, $strEntidade, $strIdExcecao = ''): void
    {
        if (Validator::make($arrParams,
            ['co_cnpj' => 'unique:' . $strEntidade . ',co_cnpj' . $this->getExcept($strEntidade, $strIdExcecao)])->fails()
        ) {
            throw new BusinessException(
                BusinessException::CUSTOMIZED, 'Já existe um cadastro vinculado à este CNPJ'
            );
        }
    }

    /**
     * @param $strEntidade
     * @param string $strIdExcecao
     * @return string
     */
    protected function getExcept(?string $strEntidade, $strIdExcecao = ''): string
    {
        if (empty($strEntidade) || empty($strIdExcecao)) {
            return '';
        }
        return ',' . $strIdExcecao . ',' .$this->getIdFromEntidade($strEntidade);
    }

    /**
     * @param $strEntidade
     * @return string
     */
    private function getIdFromEntidade($strEntidade): string
    {
        return str_replace('tb', 'id', $strEntidade);
    }

    /**
     * @param $arrParams
     * @throws BusinessException
     */
    public function validarDataNascimento($arrParams): void
    {
        $arrParams['dt_nascimento'] = isset($arrParams['dt_nascimento']) ? U::convertDate($arrParams['dt_nascimento']) : null;
        if (Validator::make($arrParams, ['dt_nascimento' => 'nullable|after:date'])->fails()) {
            throw new BusinessException(BusinessException::INVALID_PARAM, 'Data de Nascimento');
        }
    }

    /**
     * @param $arrParams
     * @throws BusinessException
     */
    public function validarFotoObrigatorio($arrParams): void
    {
        if (Validator::make($arrParams,
            ['tx_foto' => 'string|required'])->fails()
        ) {
            throw new BusinessException(BusinessException::INVALID_PARAM, 'Foto');
        }
    }

    /**
     * @param array|null $arrParams
     * @return bool
     */
    private function isCpfInvalido(?array $arrParams = array()): bool
    {
        // Verifica se um número foi informado
        if (!isset($arrParams['co_cpf']) || empty($arrParams['co_cpf'])) {
            return false;
        }

        $cpf = $arrParams['co_cpf'];

        // Elimina possivel mascara
        $cpf = preg_replace("/[^0-9]/", "", $cpf);
        $cpf = str_pad($cpf, 11, '0', STR_PAD_LEFT);

        // Verifica se o numero de digitos informados é igual a 11
        if (strlen($cpf) != 11) {
            return true;
        }
        // Verifica se nenhuma das sequências invalidas abaixo
        // foi digitada. Caso afirmativo, retorna falso
        else if ($cpf == '00000000000' ||
            $cpf == '11111111111' ||
            $cpf == '22222222222' ||
            $cpf == '33333333333' ||
            $cpf == '44444444444' ||
            $cpf == '55555555555' ||
            $cpf == '66666666666' ||
            $cpf == '77777777777' ||
            $cpf == '88888888888' ||
            $cpf == '99999999999') {
            return true;
            // Calcula os digitos verificadores para verificar se o
            // CPF é válido
        } else {
            for ($t = 9; $t < 11; $t++) {

                for ($d = 0, $c = 0; $c < $t; $c++) {
                    $d += $cpf{$c} * (($t + 1) - $c);
                }
                $d = ((10 * $d) % 11) % 10;
                if ($cpf{$c} != $d) {
                    return true;
                }
            }
            return false;
        }
    }

    /**
     * @param array|null $arrParams
     * @return bool
     */
    private function isCnpjInvalido(?array $arrParams = array()): bool
    {
        // Verifica se um número foi informado
        if (!isset($arrParams['co_cnpj']) || empty($arrParams['co_cnpj'])) {
            return false;
        }

        $cnpj = $arrParams['co_cnpj'];

        $cnpj = preg_replace('/[^0-9]/', '', (string)$cnpj);
        // Valida tamanho
        if (strlen($cnpj) != 14)
            return true;
        // Valida primeiro dígito verificador
        for ($i = 0, $j = 5, $soma = 0; $i < 12; $i++) {
            $soma += $cnpj{$i} * $j;
            $j = ($j == 2) ? 9 : $j - 1;
        }
        $resto = $soma % 11;
        if ($cnpj{12} != ($resto < 2 ? 0 : 11 - $resto))
            return true;
        // Valida segundo dígito verificador
        for ($i = 0, $j = 6, $soma = 0; $i < 13; $i++) {
            $soma += $cnpj{$i} * $j;
            $j = ($j == 2) ? 9 : $j - 1;
        }
        $resto = $soma % 11;
        return !($cnpj{13} == ($resto < 2 ? 0 : 11 - $resto));
    }
}
