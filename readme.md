# Technologies Used:
XAMPP for Windows 7.2.34, Laravel 5.8 Framework, and guzzlehttp/guzzle package.

# Features
1. Seeder for the top rated, and upcoming movies along with movies' genres from The Movie DB (https://www.themoviedb.org) with a configurable frequency and configuration for the no. of seeded movies for both top rated and upcoming movies, and store the seeded data in database.

We seed the data from the below three services:

https://api.themoviedb.org/3/genre/movie/list?api_key=<<api_key>>&language=en-US

https://api.themoviedb.org/3/movie/top_rated?api_key=<<api_key>>&language=en-US&page=1

https://api.themoviedb.org/3/movie/upcoming?api_key=<<api_key>>&language=en-US&page=1



2. An API endpoint `/public/movies` to list all the movies from the database with the ability to filter them by the genre and sort the movies list according to the popularity, vote average, and vote rate. We will use the following URLs:

/public/movies?genre=war (We retrieve movies by the genre)

/public/movies?popular|asc , /public/movies?popular|desc (according to the popularity ascending or descending respectively) 

/public/movies?rated|asc , /public/movies?rated|desc (according to the vote average ascending or descending respectively)

/public/movies?vote|asc , /public/movies?vote|desc (according to the vote count ascending or descending respectively)


# Steps to install & run

1. Install XAMPP for Windows 7.2.34.

2. Clone this repository inside the folder 'htdocs' in XAMPP. There will be a newly created folder called 'michael_movie_api' in 'htdocs' folder.

3. Open phpMyAdmin and create a new database (e.g. 'movie_seeder').

4. Create a new file '.env' in the folder 'michael_movie_api' and copy the content of the '.env.example' in it.

5. In .env file add the name of the just created databse in the attribute, 'DB_DATABASE'.

6. In .env add configurations for the frequency of seeding the movies (name of the attribute 'MOVIES_SEEDER_FREQUENCY'), number of the required seeded top rated movies (name of the attribute 'TOP_RATED_MOVIES_NO'), and  number of the required seeded upcoming movies (name of the attribute 'UPCOMING_MOVIES_NO').

7. Go to the folder 'michael_movie_api' in 'htdocs' folder and open 'Windows PowerShell'.

8. Run the command 'composer install', and then run 'php artisan migrate:fresh'.

9. After that, run the command 'php artisan schedule:run' to force running the scheduler.

10. Open phpMyAdmin and you will find the seeded data stored in the database.

11. Start testing API by the following URLs:

/michael_movie_api/public/movies?genre=romance (Retrieving the movies by the genre name)

/michael_movie_api/public/movies?popular|asc , /michael_movie_api/public/movies?popular|desc (sorting the movies according to the popularity ascending or descending respectively) 

/michael_movie_api/public/movies?rated|asc , /michael_movie_api/public/movies?rated|desc (sorting the movies according to the vote average ascending or descending respectively)

/michael_movie_api/public/movies?vote|asc , /michael_movie_api/public/movies?vote|desc (sorting the movies according to the vote count ascending or descending respectively)

12. The default order is ascending if you don't sepcify it in URL (e.g. /michael_movie_api/public/movies?popular).
