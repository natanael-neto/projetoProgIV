<?php

namespace Proxies\__CG__\models\entidades;

/**
 * THIS CLASS WAS GENERATED BY THE DOCTRINE ORM. DO NOT EDIT THIS FILE.
 */
class Pessoa extends \models\entidades\Pessoa implements \Doctrine\ORM\Proxy\Proxy
{
    private $_entityPersister;
    private $_identifier;
    public $__isInitialized__ = false;
    public function __construct($entityPersister, $identifier)
    {
        $this->_entityPersister = $entityPersister;
        $this->_identifier = $identifier;
    }
    /** @private */
    public function __load()
    {
        if (!$this->__isInitialized__ && $this->_entityPersister) {
            $this->__isInitialized__ = true;

            if (method_exists($this, "__wakeup")) {
                // call this after __isInitialized__to avoid infinite recursion
                // but before loading to emulate what ClassMetadata::newInstance()
                // provides.
                $this->__wakeup();
            }

            if ($this->_entityPersister->load($this->_identifier, $this) === null) {
                throw new \Doctrine\ORM\EntityNotFoundException();
            }
            unset($this->_entityPersister, $this->_identifier);
        }
    }

    /** @private */
    public function __isInitialized()
    {
        return $this->__isInitialized__;
    }

    
    public function getNome()
    {
        $this->__load();
        return parent::getNome();
    }

    public function setNome($nome)
    {
        $this->__load();
        return parent::setNome($nome);
    }

    public function getIdade()
    {
        $this->__load();
        return parent::getIdade();
    }

    public function setIdade($idade)
    {
        $this->__load();
        return parent::setIdade($idade);
    }

    public function __toString()
    {
        $this->__load();
        return parent::__toString();
    }

    public function save($attributes)
    {
        $this->__load();
        return parent::save($attributes);
    }

    public function getId()
    {
        if ($this->__isInitialized__ === false) {
            return (int) $this->_identifier["id"];
        }
        $this->__load();
        return parent::getId();
    }

    public function setId($id)
    {
        $this->__load();
        return parent::setId($id);
    }

    public function getDataRegistro()
    {
        $this->__load();
        return parent::getDataRegistro();
    }

    public function setDataRegistro($dataRegistro)
    {
        $this->__load();
        return parent::setDataRegistro($dataRegistro);
    }

    public function getDataModificacao()
    {
        $this->__load();
        return parent::getDataModificacao();
    }

    public function setDataModificacao($dataModificacao)
    {
        $this->__load();
        return parent::setDataModificacao($dataModificacao);
    }

    public function atualizarDataModificacao()
    {
        $this->__load();
        return parent::atualizarDataModificacao();
    }

    public function getClassName()
    {
        $this->__load();
        return parent::getClassName();
    }

    public function jsonSerialize()
    {
        $this->__load();
        return parent::jsonSerialize();
    }


    public function __sleep()
    {
        return array('__isInitialized__', 'nome', 'idade', 'id', 'dataRegistro', 'dataModificacao');
    }

    public function __clone()
    {
        if (!$this->__isInitialized__ && $this->_entityPersister) {
            $this->__isInitialized__ = true;
            $class = $this->_entityPersister->getClassMetadata();
            $original = $this->_entityPersister->load($this->_identifier);
            if ($original === null) {
                throw new \Doctrine\ORM\EntityNotFoundException();
            }
            foreach ($class->reflFields as $field => $reflProperty) {
                $reflProperty->setValue($this, $reflProperty->getValue($original));
            }
            unset($this->_entityPersister, $this->_identifier);
        }
        parent::__clone();
    }
}