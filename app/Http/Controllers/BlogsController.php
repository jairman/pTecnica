<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Pagination\Paginator;
use jcobhams\NewsApi\NewsApi;
use Illuminate\Pagination\LengthAwarePaginator;

class BlogsController extends Controller
{



    public function index(Request $request)
    {

        $apiKey = '2c41363a9e9443f894d7979debee1aa3';
        $endpoint = 'https://newsapi.org/v2/top-headlines';
        $randomUser = 'https://randomuser.me/api/';

        $pageSize = 10;
        $page = $request->get('page', 1);


        $response = Http::get("$endpoint?country=us&pageSize=$pageSize&page=$page&apiKey=$apiKey");


        $articles = $response->json()['articles'];
        $data = [];

        foreach ($articles as $article) {
            $authorResponse = Http::get($randomUser);
            $author = $authorResponse->json()['results'][0]['name'];
            $file   = $authorResponse->json()['results'][0]['picture']['large'];

            $data[] = [
                'title' => $article['title'],
                'description' => $article['description'],
                'author' => $author['first'] . ' ' . $author['last'],
                'image' => $file,
            ];
        }

        $news = $response->json();

        $articlespag = collect($news['articles']);

        $totalResults = $news['totalResults'] ?? 0;

        $currentPage = $page;
        $perPage = $pageSize;

        $paginator = new LengthAwarePaginator(
            $articlespag->forPage($currentPage, $perPage),
            $totalResults,
            $perPage,
            $currentPage,
            ['path' => $request->url(), 'query' => $request->query()]
        );




        return view('blogs.index', compact('data', 'paginator'));
    }



}
