<?php
/**
 * Copyright 2014 Arnaud Bienvenu
 *
 * This file is part of Kyela.

 * Kyela is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Affero General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.

 * Kyela is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU Affero General Public License for more details.

 * You should have received a copy of the GNU Affero General Public License
 * along with Kyela.  If not, see <http://www.gnu.org/licenses/>.
 *
 */

namespace Abienvenu\KyelaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Abienvenu\KyelaBundle\Entity\Entity;

/**
 * Poll
 *
 * @ORM\Table(uniqueConstraints={@ORM\UniqueConstraint(name="url_idx", columns={"url"})})
 * @UniqueEntity(fields={"url"})
 * @ORM\Entity
 */
class Poll extends Entity
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="url", type="string", length=255)
     */
    private $url;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;

	/**
	 * @ORM\OneToMany(targetEntity="Participant", mappedBy="poll", cascade={"remove"})
	 */
	private $participants;

	/**
	 * @ORM\OneToMany(targetEntity="Event", mappedBy="poll", cascade={"remove"})
	 */
	private $events;

	/**
	 * @ORM\OneToMany(targetEntity="Choice", mappedBy="poll", cascade={"remove", "persist"})
	 */
	private $choices;

	/**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set url
     *
     * @param string $url
     * @return Poll
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
     * Set title
     *
     * @param string $title
     * @return Poll
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
        return $this->title;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->participants = new \Doctrine\Common\Collections\ArrayCollection();
        $this->events = new \Doctrine\Common\Collections\ArrayCollection();
        $this->choices = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add participants
     *
     * @param \Abienvenu\KyelaBundle\Entity\Participant $participants
     * @return Poll
     */
    public function addParticipant(\Abienvenu\KyelaBundle\Entity\Participant $participants)
    {
        $this->participants[] = $participants;

        return $this;
    }

    /**
     * Remove participants
     *
     * @param \Abienvenu\KyelaBundle\Entity\Participant $participants
     */
    public function removeParticipant(\Abienvenu\KyelaBundle\Entity\Participant $participants)
    {
        $this->participants->removeElement($participants);
    }

    /**
     * Get participants
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getParticipants()
    {
        return $this->participants;
    }

    /**
     * Add events
     *
     * @param \Abienvenu\KyelaBundle\Entity\Event $events
     * @return Poll
     */
    public function addEvent(\Abienvenu\KyelaBundle\Entity\Event $events)
    {
        $this->events[] = $events;

        return $this;
    }

    /**
     * Remove events
     *
     * @param \Abienvenu\KyelaBundle\Entity\Event $events
     */
    public function removeEvent(\Abienvenu\KyelaBundle\Entity\Event $events)
    {
        $this->events->removeElement($events);
    }

    /**
     * Get events
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getEvents()
    {
        return $this->events;
    }

    /**
     * Add choices
     *
     * @param \Abienvenu\KyelaBundle\Entity\Choice $choices
     * @return Poll
     */
    public function addChoice(\Abienvenu\KyelaBundle\Entity\Choice $choices)
    {
        $this->choices[] = $choices;

        return $this;
    }

    /**
     * Remove choices
     *
     * @param \Abienvenu\KyelaBundle\Entity\Choice $choices
     */
    public function removeChoice(\Abienvenu\KyelaBundle\Entity\Choice $choices)
    {
        $this->choices->removeElement($choices);
    }

    /**
     * Get choices
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getChoices()
    {
        return $this->choices;
    }
}
