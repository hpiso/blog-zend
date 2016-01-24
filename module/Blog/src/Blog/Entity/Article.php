<?php
 
namespace Blog\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 *
 * @ORM\Entity(repositoryClass="Blog\Repository\ArticleRepository")
 * @ORM\Table(name="arcticles")
 *
 */
class Article
{
    /**
     * @var int
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     * @ORM\Column(name="title", type="string", length=255, nullable=false)
     */
    public $title;

    /**
     * @var string
     * @ORM\Column(name="content", type="text")
     */
    public $content;

    /**
     * @var string
     * @ORM\Column(name="date", type="datetime")
     */
    public $date;

    /**
     * @var Boolean
     * @ORM\Column(name="state", type="boolean")
     */
    public $state;

//    /**
//     * @ORM\ManyToOne(targetEntity="Blog\Entity\User")
//     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
//     */
//    protected $user;

    /**
     *
     * @ORM\ManyToOne(targetEntity="Blog\Entity\Category")
     * @ORM\JoinColumn(name="category_id", referencedColumnName="id")
     *
     */
    protected $category;

    public function __construct(){
        $this->date = new \DateTime();
    }

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
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @param string $content
     */
    public function setContent($content)
    {
        $this->content = $content;
    }

    /**
     * @return string
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param string $date
     */
    public function setDate($date)
    {
        $this->date = $date;
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

    /**
     * @return mixed
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param mixed $user
     */
    public function setUser($user)
    {
        $this->user = $user;
    }

    /**
     * @return mixed
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * @param mixed $category
     */
    public function setCategory($category)
    {
        $this->category = $category;
    }

}
