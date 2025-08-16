<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class PageController extends AbstractController
{
    #[Route('/plan-du-site', name: 'page_sitemap')]
    public function sitemap(): Response
    {
        return $this->render('page/sitemap.html.twig');
    }

    #[Route('/a-propos', name: 'page_about')]
    public function about(): Response
    {
        return $this->render('page/about.html.twig');
    }

    #[Route('/infos-legales', name: 'page_legal')]
    public function legal(): Response
    {
        return $this->render('page/legal.html.twig');
    }

    // src/Controller/SitemapController.php
    #[Route('/sitemap.xml', name: 'sitemap_xml')]
    public function sitemapXml(UrlGeneratorInterface $url): Response
    {
        $urls = [
            $url->generate('animal_search', [], UrlGeneratorInterface::ABSOLUTE_URL),
            $url->generate('organisation_search', [], UrlGeneratorInterface::ABSOLUTE_URL),
            $url->generate('page_about', [], UrlGeneratorInterface::ABSOLUTE_URL),
            $url->generate('page_legal', [], UrlGeneratorInterface::ABSOLUTE_URL),
            $url->generate('page_sitemap', [], UrlGeneratorInterface::ABSOLUTE_URL),
        ];
        $xml = new \SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?><urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"/>');
        foreach ($urls as $u) {
            $n = $xml->addChild('url');
            $n->addChild('loc', htmlspecialchars($u, ENT_XML1));
        }
        return new Response($xml->asXML(), 200, ['Content-Type' => 'application/xml']);
    }

}