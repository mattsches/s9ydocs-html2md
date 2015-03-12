<?php
require __DIR__ . '/../vendor/autoload.php';

use Symfony\Component\Console\Application;
use Symfony\Component\DomCrawler\Crawler;

$console = new Application();

$console
    ->register('parse')
    ->setDescription('Displays the files in the given directory')
    ->setCode(
        function () {
            /**
             * List taken from https://github.com/s9y/s9y.github.io/blob/master/todo.txt
             */
            $urls = array(
                'http://www.s9y.org/12.html',
                'http://www.s9y.org/11.html',
                'http://www.s9y.org/148.html',
                'http://www.s9y.org/150.html',
                'http://www.s9y.org/159.html',
                'http://www.s9y.org/197.html',
                'http://www.s9y.org/163.html',
                'http://www.s9y.org/165.html',
                'http://www.s9y.org/172.html',
                'http://www.s9y.org/215.html',
                'http://www.s9y.org/214.html',
                'http://www.s9y.org/216.html',
                'http://www.s9y.org/166.html',
                'http://www.s9y.org/170.html',
                'http://www.s9y.org/164.html',
                'http://www.s9y.org/169.html',
                'http://www.s9y.org/203.html',
                'http://www.s9y.org/198.html',
                'http://www.s9y.org/161.html',
                'http://www.s9y.org/209.html',
                'http://www.s9y.org/210.html',
                'http://www.s9y.org/162.html',
                'http://www.s9y.org/forums/viewtopic.php?t=6110',
                'http://www.s9y.org/208.html',
                'http://www.s9y.org/204.html',
                'http://www.s9y.org/152.html',
                'http://www.s9y.org/158.html',
                'http://www.s9y.org/157.html',
                'http://www.s9y.org/61.html',
                'http://www.s9y.org/20.html',
                'http://www.s9y.org/36.html',
                'http://www.s9y.org/37.html',
                'http://www.s9y.org/41.html',
                'http://www.s9y.org/53.html',
                'http://www.s9y.org/55.html',
                'http://www.s9y.org/39.html',
                'http://www.s9y.org/45.html',
                'http://www.s9y.org/47.html',
                'http://www.s9y.org/48.html',
                'http://www.s9y.org/49.html',
                'http://www.s9y.org/50.html',
                'http://www.s9y.org/66.html',
                'http://www.s9y.org/67.html',
                'http://www.s9y.org/68.html',
                'http://www.s9y.org/69.html',
                'http://www.s9y.org/70.html',
                'http://www.s9y.org/75.html',
                'http://www.s9y.org/103.html',
                'http://www.s9y.org/155.html',
                'http://www.s9y.org/42.html',
                'http://www.s9y.org/44.html',
                'http://www.s9y.org/46.html',
                'http://www.s9y.org/78.html',
                'http://www.s9y.org/102.html',
                'http://www.s9y.org/116.html',
                'http://www.s9y.org/119.html',
                'http://www.s9y.org/121.html',
                'http://www.s9y.org/137.html',
                'http://www.s9y.org/194.html',
                'http://www.s9y.org/217.html',
                'http://www.s9y.org/82.html',
                'http://www.s9y.org/96.html',
                'http://www.s9y.org/219.html',
            );

            $client = new GuzzleHttp\Client();
            foreach ($urls as $url) {
                $path = substr(parse_url($url, PHP_URL_PATH), 1);
                try {
                    $response = $client->get($url);
                } catch (\GuzzleHttp\Exception\RequestException $e) {
                    continue;
                }
                $html = $response->getBody()->getContents();
                if (!$html) {
                    continue;
                }
                $crawler = new Crawler($html);
                $htmlContent = $crawler = $crawler->filter('div.content')->html();
                $pandoc = new \Pandoc\Pandoc();
                $markdownContent = $pandoc->convert($htmlContent, "html", "markdown_github");
                file_put_contents('markdown/' . $path . '.md', $markdownContent);
            }

        }
    );

$console->run();
