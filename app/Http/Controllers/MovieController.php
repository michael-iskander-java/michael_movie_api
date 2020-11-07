<?php

namespace App\Http\Controllers;

use App\Genre;
use App\Movie;
use App\GenreMovie;
use App\Http\Resources\MovieResource;
use Illuminate\Http\Request;


class MovieController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        //
    }


    public function getMovies(){


        $genreArgument=request()->query('genre');


        if($genreArgument==null){

            $queryString=request()->query();
            $queryStringKey = key($queryString);


            $splitQueryString = explode('|', $queryStringKey, 2);

            $firstParameter = $splitQueryString[0];
            $secondParameter = empty($splitQueryString[1]) ? 'asc': $splitQueryString[1];


            if($secondParameter=='asc' || $secondParameter=='desc') {
                switch ($firstParameter) {

                    case 'popular':
                        $popularMovies = Movie::with('genres')->orderBy('popularity', $secondParameter)->get();
                        $resultPopularMovies = MovieResource::collection($popularMovies);
                        return response()->json($resultPopularMovies);

                    case 'rated':
                        $ratedMovies = Movie::with('genres')->orderBy('vote_average', $secondParameter)->get();
                        $resultRatedMovies = MovieResource::collection($ratedMovies);
                        return response()->json($resultRatedMovies);

                    case 'vote':
                        $votedMovies = Movie::with('genres')->orderBy('vote_count', $secondParameter)->get();
                        $resultVotedMovies = MovieResource::collection($votedMovies);
                        return response()->json($resultVotedMovies);

                    default:
                        return response()->json('Not Supported Parameter');
                }
            }else{
                return response()->json('Order direction must be "asc" or "desc".');
            }
        }else {
            $genre = Genre::where('name',$genreArgument)->first();
            if ($genre==null){
                return response()->json('There is no Genre with such name: '.$genreArgument);
            }
            //dd($genre);
            $moviesIDs =GenreMovie::where ('genre_id', $genre->id)->pluck('movie_id')->toArray();

            if ($moviesIDs==null){
                return response()->json('There is no movies for the genre: '.$genreArgument);
            }

            //dd($movies_id);
            $movies = Movie::whereIn('id',$moviesIDs)->with('genres')->get();

            // dd($movies);
            $resultedMovies = MovieResource::collection($movies);
            return response()->json($resultedMovies);
        }
    }
}
