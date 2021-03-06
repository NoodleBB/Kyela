<?php
/*
 * Copyright 2014-2016 Arnaud Bienvenu
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

namespace Abienvenu\KyelaBundle\Controller;

use Abienvenu\KyelaBundle\Entity\Choice;
use Abienvenu\KyelaBundle\Entity\Event;
use Abienvenu\KyelaBundle\Entity\Participant;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Abienvenu\KyelaBundle\Entity\Participation;

/**
 * Participation controller.
 *
 * @Route("/participation")
 */
class ParticipationController extends Controller
{
    /**
     * Creates a new Participation on the fly.
     *
     * @Route("/new/{event}/{participant}/{choice}", name="participation_new")
     * @Method("GET")
     */
    public function newAction(Event $event, Participant $participant, Choice $choice)
    {
        $em = $this->getDoctrine()->getManager();

        // If participation exists, editAction should have been called, not newAction
        // But just in case, we look for an existing participation
        $participation = $em->getRepository('KyelaBundle:Participation')->findOneBy(['participant' => $participant->getId(), 'event' => $event->getId()]);
        if (!$participation)
        {
            $participation = new Participation();
        }
        $participation->setEvent($event);
        $participation->setParticipant($participant);
        $participation->setChoice($choice);

        $em->persist($participation);
        $em->flush();
        return $this->render(
            'KyelaBundle:Poll:_participation_cell.html.twig',
            ['participation' => $participation, 'choices' => $event->getPoll()->getChoices(), 'event' => $event, 'participant' => $participant]);
    }

    /**
     * Edits a Participation on the fly
     *
     * @Route("/edit/{participation}/{newChoice}", name="participation_edit")
     * @Method("GET")
     */
    public function editAction(Participation $participation, Choice $newChoice)
    {
        $em = $this->getDoctrine()->getManager();

        $participation->setChoice($newChoice);
        $em->flush();
        return $this->render(
            'KyelaBundle:Poll:_participation_cell.html.twig',
            [
                'participation' => $participation,
                'choices' => $newChoice->getPoll()->getChoices(),
                'event' => $participation->getEvent(),
                'participant' => $participation->getParticipant()
            ]
        );
    }

    /**
     * Removes a Participation on the fly
     *
     * @Route("/delete/{participation}", name="participation_delete")
     * @Method("GET")
     */
    public function deleteAction(Participation $participation)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($participation);
        $em->flush();
        return $this->render(
            'KyelaBundle:Poll:_participation_cell.html.twig',
            [
                'participation' => null,
                'choices' => $participation->getEvent()->getPoll()->getChoices(),
                'event' => $participation->getEvent(),
                'participant' => $participation->getParticipant()
            ]
        );
    }
}
