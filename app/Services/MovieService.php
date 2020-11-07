<?php

namespace App\Services;
use App\Genre;
use App\Movie;

class MovieService
{

    public function addGenres()
    {
        \Log::info("Genre Logs");

        $client = new \GuzzleHttp\Client();

        $result = $client->request('GET', 'https://api.themoviedb.org/3/genre/movie/list',
            [
                'query' => [
                    'api_key' => config('services.movies_db_api.key')
                ]]);
        $genresBody = json_decode($result->getBody(), true);

        $genresArray = $genresBody['genres'];

        foreach ($genresArray as $genreItem) {

            $genreRecord = array(
                "genres_id" => $genreItem['id'],
                "name" => $genreItem['name'],
            );
            $movie = Genre::updateOrCreate($genreRecord);
        }
    }

    public function addTopRatedMovies()
    {
        $client = new \GuzzleHttp\Client();

        $moviesUpdated = 0;

        \Log::info("Begin List of Top Rated Movies");

        for ($page = 1; $page <= 1000; $page++) {
            $res = $client->request('GET', 'https://api.themoviedb.org/3/movie/top_rated',
                [
                    'query' => [
                        'api_key' => config('services.movies_db_api.key'),
                        'page' => $page,
                    ]
                ]);

            $moviesBody = json_decode($res->getBody());

            $moviesArray = $moviesBody->results;

            foreach ($moviesArray as $movieItem) {


                $movieRecord = array(
                    //"mdb_id" => $movieItem->id,
                    "popularity" => $movieItem->popularity,
                    "vote_count" => $movieItem->vote_count,
                    "video" => $movieItem->video,
                    "poster_path" => $movieItem->poster_path,
                    "adult" => $movieItem->adult,
                    "backdrop_path" => $movieItem->backdrop_path,
                    "original_language" => $movieItem->original_language,
                    "original_title" => $movieItem->original_title,
                    "title" => $movieItem->title,
                    "vote_average" => $movieItem->vote_average,
                    "overview" => $movieItem->overview,
                    "release_date" => $movieItem->release_date,
                );

                // Replace empty strings by NULL
                $movieRecord = array_map(function ($value) {
                    return $value === "" ? null : $value;
                }, $movieRecord);

                //update or create movies
                $movie = Movie::updateOrCreate(
                    ['mdb_id' => $movieItem->id],
                    $movieRecord
                );

                $genresPrimaryKeys = Genre::whereIn('genres_id',$movieItem->genre_ids)->pluck('id')->toArray();
                $movie->genres()->sync($genresPrimaryKeys);

                $moviesUpdated++;

                \Log::info("$moviesUpdated => mdb_id =>$movieItem->id");
                if ($moviesUpdated >= config('services.movies_db_api.top_rated_movies_no_per_fetch')) {
                    break;
                }
            }

            if ($moviesUpdated >= config('services.movies_db_api.top_rated_movies_no_per_fetch') or $page >= $moviesBody->total_pages) {
                break;
            }

            // Avoid API limitations
            if ($page % 40 == 0) {
                sleep(9);
            }
        }

        \Log::info("End List of Top Rated Movies");
    }

    public function addUpcomingMovies()
    {
        $client = new \GuzzleHttp\Client();

        $moviesUpdated = 0;

        \Log::info("Start List of Upcoming Movies");
        for ($page = 1; $page <= 1000; $page++) {
            $res = $client->request('GET', 'https://api.themoviedb.org/3/movie/upcoming',
                [
                    'query' => [
                        'api_key' => config('services.movies_db_api.key'),
                        'page' => $page,
                    ]
                ]);

            $upcomingMoviesBody = json_decode($res->getBody());
            //dd($upcomingMoviesBody);


            $upcomingMoviesArray = $upcomingMoviesBody->results;

            //dd($upcomingMoviesArr);

            foreach ($upcomingMoviesArray as $upcomingMovieItem) {
                $upcomingMovieRecord = array(
                    //"mdb_id" => $upcomingMovieItem->id,
                    "popularity" => $upcomingMovieItem->popularity,
                    "vote_count" => $upcomingMovieItem->vote_count,
                    "video" => $upcomingMovieItem->video,
                    "poster_path" => $upcomingMovieItem->poster_path,
                    "adult" => $upcomingMovieItem->adult,
                    "backdrop_path" => $upcomingMovieItem->backdrop_path,
                    "original_language" => $upcomingMovieItem->original_language,
                    "original_title" => $upcomingMovieItem->original_title,
                    "title" => $upcomingMovieItem->title,
                    "vote_average" => $upcomingMovieItem->vote_average,
                    "overview" => $upcomingMovieItem->overview,
                    "release_date" => $upcomingMovieItem->release_date,
                );

                // Replace empty strings by NULL
                $upcomingMovieRecord = array_map(function ($value) {
                    return $value === "" ? null : $value;
                }, $upcomingMovieRecord);



                $movie = Movie::updateOrCreate(
                    ['mdb_id' => $upcomingMovieItem->id],
                    $upcomingMovieRecord
                );

                $genresPrimaryKeys = Genre::whereIn('genres_id',$upcomingMovieItem->genre_ids)->pluck('id')->toArray();
                $movie->genres()->sync($genresPrimaryKeys);


                $moviesUpdated++;

                \Log::info("$moviesUpdated => mdb_id =>$upcomingMovieItem->id");

                if ($moviesUpdated >= config('services.movies_db_api.upcoming_movies_no_per_fetch')) {
                    break;
                }
            }

            if ($moviesUpdated >= config('services.movies_db_api.upcoming_movies_no_per_fetch') or $page >= $upcomingMoviesBody->total_pages) {
                break;
            }

            // Avoid API limitations
            if ($page % 40 == 0) {
                sleep(9);
            }
        }
        \Log::info("End List of Upcoming Movies");
    }

}
