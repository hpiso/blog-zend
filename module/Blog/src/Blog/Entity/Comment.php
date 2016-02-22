<?php
 
namespace Blog\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 *
 * @ORM\Entity(repositoryClass="Blog\Repository\CommentRepository")
 * @ORM\Table(name="comments")
 *
 */
class Comment
{

    public function __construct(){
        $this->date = new \DateTime();
        $this->state = false;
    }

    /**
     * @var int
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    public $id;

    /**
     * @var string
     * @ORM\Column(name="name", type="string", length=255, nullable=false)
     */
    public $name;

    /**
     * @var string
     * @ORM\Column(name="email", type="string", length=255, nullable=false)
     */
    public $email;

    /**
     * @var string
     * @ORM\Column(name="content", type="text")
     */
    public $content;

    /**
     * @ORM\Column(name="date", type="datetime")
     */
    public $date;

    /**
     * @ORM\ManyToOne(targetEntity="Blog\Entity\Article", inversedBy="comments")
     * @ORM\JoinColumn(name="article_id", referencedColumnName="id", onDelete="CASCADE")
     */
    public $article;

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
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
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
     * @return mixed
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param mixed $date
     */
    public function setDate($date)
    {
        $this->date = $date;
    }

    /**
     * @return mixed
     */
    public function getArticle()
    {
        return $this->article;
    }

    /**
     * @param mixed $article
     */
    public function setArticle($article)
    {
        $this->article = $article;
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
