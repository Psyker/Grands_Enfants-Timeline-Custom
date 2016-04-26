<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Tweet
 *
 * @ORM\Table(name="tweet")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\TweetRepository")
 */
class Tweet
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="image_url", type="text", nullable=true)
     */
    private $imageUrl;

    /**
     * @var array
     *
     * @ORM\Column(name="mentions", type="simple_array", nullable=true)
     */
    private $mentions;

    /**
     * @var string
     *
     * @ORM\Column(name="url", type="string", length=255, unique=true)
     */
    private $url;

    /**
     * @var array
     *
     * @ORM\Column(name="hashtags", type="simple_array", nullable=true)
     */
    private $hashtags;

    /**
     * @var string
     *
     * @ORM\Column(name="category", type="string", length=100)
     */
    private $category;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime")
     */
    private $createdAt;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;

    /**
     * @var int
     *
     * @ORM\Column(name="retweets", type="integer", nullable=true)
     */
    private $retweets;

    /**
     * @var int
     *
     * @ORM\Column(name="likes", type="integer", nullable=true)
     */
    private $likes;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set imageUrl
     *
     * @param string $imageUrl
     *
     * @return Tweet
     */
    public function setImageUrl($imageUrl)
    {
        $this->imageUrl = $imageUrl;

        return $this;
    }

    /**
     * Get imageUrl
     *
     * @return string
     */
    public function getImageUrl()
    {
        return $this->imageUrl;
    }

    /**
     * Set mentions
     *
     * @param array $mentions
     *
     * @return Tweet
     */
    public function setMentions($mentions)
    {
        $this->mentions = $mentions;

        return $this;
    }

    /**
     * Get mentions
     *
     * @return array
     */
    public function getMentions()
    {
        return $this->mentions;
    }

    /**
     * Set url
     *
     * @param string $url
     *
     * @return Tweet
     */
    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * Get url
     *
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Set hashtags
     *
     * @param array $hashtags
     *
     * @return Tweet
     */
    public function setHashtags($hashtags)
    {
        $this->hashtags = $hashtags;

        return $this;
    }

    /**
     * Get hashtags
     *
     * @return array
     */
    public function getHashtags()
    {
        return $this->hashtags;
    }

    /**
     * Set category
     *
     * @param string $category
     *
     * @return Tweet
     */
    public function setCategory($category)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * Get category
     *
     * @return string
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return Tweet
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set title
     *
     * @param string $title
     *
     * @return Tweet
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        $finalTitle = preg_replace('[http\S+]', '',$this->title);
        $finalTitle = preg_replace('/#(\w+)/', '<a href="/hashtag/$1">#$1</a>', $finalTitle);
        $finalTitle = preg_replace('/@(\w+)/', '', $finalTitle);
        return $finalTitle;
    }

    /**
     * Set retweets
     *
     * @param integer $retweets
     *
     * @return Tweet
     */
    public function setRetweets($retweets)
    {
        $this->retweets = $retweets;

        return $this;
    }

    /**
     * Get retweets
     *
     * @return int
     */
    public function getRetweets()
    {
        return $this->retweets;
    }

    /**
     * Set likes
     *
     * @param integer $likes
     *
     * @return Tweet
     */
    public function setLikes($likes)
    {
        $this->likes = $likes;

        return $this;
    }

    /**
     * Get likes
     *
     * @return int
     */
    public function getLikes()
    {
        return $this->likes;
    }
}