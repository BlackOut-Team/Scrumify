<?php
namespace ForumBundle\Concern;


trait Taggable {

    /**
     * @var array
     *
     * @ORM\ManyToMany(targetEntity="ForumBundle\Entity\Tag", cascade={"persist"})
     */
    private $tags;
    /**
     * Add tag.
     *
     * @param \ForumBundle\Entity\Tag $tag
     *
     * @return Question
     */
    public function addTag(\ForumBundle\Entity\Tag $tag)
    {
        $this->tags[] = $tag;

        return $this;
    }

    /**
     * Remove tag.
     *
     * @param \ForumBundle\Entity\Tag $tag
     *
     * @return boolean TRUE if this collection contained the specified element, FALSE otherwise.
     */
    public function removeTag(\ForumBundle\Entity\Tag $tag)
    {
        return $this->tags->removeElement($tag);
    }

    /**
     * Get tags.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getTags()
    {
        return $this->tags;
    }


}