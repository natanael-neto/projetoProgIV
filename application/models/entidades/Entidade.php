<?php

namespace models\entidades;

/** @MappedSuperclass
 * @HasLifecycleCallbacks
 */
abstract class Entidade implements \JsonSerializable {

    /** @var \CI_Controller | \MY_Controller | \API_Controller $ci  */
    private $ci;

    /**
     * @var int $id
     * @Id @Column(type="integer")
     * @GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var \DateTime $dataRegistro
     * @Column(type="datetime", columnDefinition="TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL", nullable=false)
     */
    protected $dataRegistro;

    /**
     * @var \DateTime $dataModificacao
     * @Column (type="datetime", nullable=true)
     */
    protected $dataModificacao;  

    /**
     * Entidade constructor.
     * @param bool $persist
     * @return void
     */
    public function __construct($persist = true) {
        if($persist) {
            \Doctrine::$ems->persist($this);
        }
        $this->dataRegistro = new \DateTime();
        $this->dataModificacao = new \DateTime();
    }

    /**
     * @return string
     */
    public function __toString() {
        if(isset($this->nome) && !is_null($this->nome)) {
            return $this->nome;
        }else {
            return strval($this->id);
        }
    }

    /**
     * @param string[] $attributes
     * @return string
     */
    public function save($attributes)
    {
        foreach ($attributes as $index => $attribute) {

            $function = ucfirst($index);
            $last_word = '';

            $last_word_start = strrpos($index, '_');
            if ($last_word_start) {
                $last_word = substr($index, $last_word_start + 1);
                $first_word = substr($index, 0, $last_word_start);

                $function = ucfirst($first_word);
            }

            $nameFunction = "set{$function}";

            switch ($last_word) {
                case 'id':
                    $associationClass = "models\\entidades\\" . $function;
                    $this->$nameFunction(\Doctrine::$ems->getReference($associationClass, $attribute));
                    break;
                case 'id':
                    break;
                default:
                    $this->$nameFunction($attribute);
                    break;
            }
        }

        return $this;
    }

    /**
     * @return int
     */
    public function getId() {  return $this->id; }

    /**
     * @param int $id
     * @return void
     */
    public function setId($id) { $this->id = $id; }

    /**
     * @return \DateTime
     */
    public function getDataRegistro() { return $this->dataRegistro; }

    /**
     * @param \DateTime $dataRegistro
     * @return void
     */
    public function setDataRegistro($dataRegistro) { $this->dataRegistro = $dataRegistro; }

    /**
     * @return \DateTime
     */
    public function getDataModificacao() { return $this->dataModificacao; }

    /**
     * @param \DateTime $dataModificacao
     * @return  void
     */
    public function setDataModificacao($dataModificacao) { $this->dataModificacao = $dataModificacao; }

    /**
     * @PreUpdate
     */
    public function atualizarDataModificacao() {
        $this->dataModificacao = new \DateTime();
    }

    /**
     * @return string|string[]
     */
    public function getClassName(){

        $classMetadata = \Doctrine::$ems->getClassMetadata(get_class($this));

        $className = $classMetadata->getName();
        $className = str_replace('models\\entidades\\', '', $className);

        return $className;

    }

    /**
     * @return array|mixed
     */
    public function jsonSerialize(){
        $json = [];
        $json['id'] = $this->id;
        $json['dataRegistro'] = @$this->dataRegistro?dataObjectToStr($this->dataRegistro):'';
        $json['dataModificacao'] = @$this->dataModificacao?dataObjectToStr($this->dataModificacao):'';

        return  $json;

    }

    /**
     * @return \CI_Controller|\MY_Controller|\API_Controller
     */
    protected function ci() {
        if(empty($this->ci)) $this->ci = get_instance();
        return $this->ci;
    }

    /**
     * @return \SystemCfg
     */
    protected function systemcfg() {
        return $this->ci()->systemcfg;
    }

    /**
     * @return void
     */
    public function __clone() {
        // TODO: Implement __clone() method.
        $this->id = null;
        $this->dataRegistro = new \DateTime();
        $this->dataModificacao = new \DateTime();
    }
}
