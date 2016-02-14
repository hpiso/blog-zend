<?php
 
namespace Blog\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 *
 * @ORM\Entity(repositoryClass="Blog\Repository\SettingRepository")
 * @ORM\Table(name="settings")
 *
 */
class Setting
{
    /**
     * @var int
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    public $id;

    /**
     * @var string
     * @ORM\Column(name="config_name", type="string", length=100, nullable=false)
     */
    public $configName;

    /**
     * @var int
     * @ORM\Column(name="pagination", type="smallint")
     */
    public $pagination;

    /**
     * @var string
     * @ORM\Column(name="navbar_color", type="string", length=20)
     */
    public $navbarColor;

    /**
     * @var Boolean
     * @ORM\Column(name="state", type="boolean")
     */
    public $state;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return int
     */
    public function getPagination()
    {
        return $this->pagination;
    }

    /**
     * @param int $pagination
     */
    public function setPagination($pagination)
    {
        $this->pagination = $pagination;
    }

    /**
     * @return string
     */
    public function getNavbarColor()
    {
        return $this->navbarColor;
    }

    /**
     * @param string $navbarColor
     */
    public function setNavbarColor($navbarColor)
    {
        $this->navbarColor = $navbarColor;
    }

    /**
     * @return string
     */
    public function getConfigName()
    {
        return $this->configName;
    }

    /**
     * @param string $configName
     */
    public function setConfigName($configName)
    {
        $this->configName = $configName;
    }

    /**
     * @return boolean
     */
    public function isState()
    {
        return $this->state;
    }

    /**
     * @param boolean $state
     */
    public function setState($state)
    {
        $this->state = $state;
    }



}
