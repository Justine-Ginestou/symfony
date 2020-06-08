<?php
//src/Controller/WildController.php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Program;
use App\Entity\Category;
use App\Entity\Season;
use App\Entity\Episode;

class WildController extends AbstractController
{
    /**
     * @Route("/wild", name="wild_index")
     * @return Response A response instance
     */
    public function index(): Response
    {
        $programs = $this->getDoctrine()
            ->getRepository(Program::class)
            ->findAll();
        if(!$programs) {
            throw $this->createNotFoundException(
                'Not program found in program\'s table.'
            );
        }return $this->render('wild/home.html.twig', ['programs' => $programs]);
    }

    /**
     * @param string $slug The Slugger
     * @Route("/wild/show/{slug}", requirements={"slug"="[a-z0-9-]+"}, name="wild_show")
     * @return Response
     */
    public function show(?string $slug): Response
    {
        if (!$slug) {
            throw $this->createNotFoundException('No slug has been sent to find a program in program\'s table.');
        }
        $slug = preg_replace(
            '/-/', ' ', ucwords(trim(strip_tags($slug)), "-"));
        $program = $this->getDoctrine()
            ->getRepository(Program::class)
            ->findOneBy(['title' => mb_strtolower($slug)]);
        if (!$program) {
            throw $this->createNotFoundException(
                'No program with ' . $slug . ' title, found in program\'s table.'
            );
        }
        return $this->render('wild/show.html.twig', [
            'program' => $program,
            'slug' => $slug,
        ]);
    }

    /**
     * @param string $categoryName
     * @Route("wild/category/{categoryName}", name="show_category")
     */
    public function showByCategory(string $categoryName)
    {
        if(!$categoryName){
            throw $this->createNotFoundException('No category is selected, please choose a category');
        }
        $category = $this->getDoctrine()
            ->getRepository(Category::class)
            ->findOneBy(['name'=>$categoryName]);

        $programs = $this->getDoctrine()
            ->getRepository(Program::class)
            ->findBy(['category'=>$category], ['id'=>'desc'], 3);
        return $this->render('wild/category.html.twig', [
            'programs'=> $programs,
            'category'=> $category
        ]);
    }

    /**
     * @param string $slug
     * @Route("wild/program/{slug}", name="show_by_program")
     */
    public function showByProgram(string $slug)
    {
        if(!$slug){
            throw $this->createNotFoundException('No serie is selected, please choose a serie');
        }
        $program = $this->getDoctrine()
            ->getRepository(Program::class)
            ->findOneBy(['title'=>$slug]);
        $seasons = $program->getSeasons();
         return $this->render('wild/showByProgram.html.twig', [
             'seasons'=> $seasons,
             'program'=> $program
         ]);
    }

    /**
     * @param int $id
     * @Route("wild/program/season/{id}", name="show_by_season")
     */
    public function showBySeason(int $id)
    {
        $season = $this->getDoctrine()
            ->getRepository(Season::class)
            ->findOneBy(['id'=>$id]);
        $episodes = $season->getEpisodes();
        $program = $season->getProgram();
        return $this->render('wild/showBySeason.html.twig', [
            'episodes'=> $episodes,
            'season'=> $season,
            'program'=>$program
        ]);
    }

    /**
     * @Route("wild/episode/{id}", name="show_episode")
     * @param Episode $episode
     * @return Response
     */
    public function showEpisode(Episode $episode)
    {
        $season = $episode->getSeason();
        $program = $season->getProgram();
        return $this->render('wild/showEpisode.html.twig', [
            'episode' => $episode,
            'season'=> $season,
            'program'=> $program
        ]);
    }
}