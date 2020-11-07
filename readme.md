# Technologies Used:
XAMPP for Windows 7.2.34, Laravel 5.8 Framework, and guzzlehttp/guzzle package.

# Features
1. Seeder for the top rated, and upcoming movies along with movies' genres from The Movie DB (https://www.themoviedb.org) with a configurable frequency and configuration for the no. of seeded movies for both top rated and upcoming movies. 
We retrieve the data from the below three services:
https://api.themoviedb.org/3/genre/movie/list?api_key=<<api_key>>&language=en-US
https://api.themoviedb.org/3/movie/top_rated?api_key=<<api_key>>&language=en-US&page=1
https://api.themoviedb.org/3/movie/upcoming?api_key=<<api_key>>&language=en-US&page=1



2. An API endpoint `/public/movies` to list all movies in the database with the ability to filter by the genre and sort the movies list according to the popularity, vote average, and vote rate. We will use the following URLs:

/public/movies?genre=war (We retrieve movies by the genre)
/public/movies?popular|asc , /public/movies?popular|desc (according to the popularity ascending or descending respectively) 
/public/movies?rated|asc , /public/movies?rated|desc (according to the vote average ascending or descending respectively)
/public/movies?vote|asc , /public/movies?vote|desc (according to the vote count ascending or descending respectively)


# Steps to install & run
1. Clone this repository inside the folder 'htdocs' in XAMPP.
2. Open phpMyAdmin and create a new database (e.g. 'movie_seeder').
3. In .env file add the name of the jusct created databse in the attribute, 'DB_DATABASE'.
4. In .env add configurations for the frequency of seeding the movies (name of the attribute 'MOVIES_SEEDER_FREQUENCY'), number of the required seeded top rated movies (name of the attribute 'TOP_RATED_MOVIES_NO'), and  number of the required seeded upcoming movies (name of the attribute 'UPCOMING_MOVIES_NO').
5. Go the folder of the repository in 'htdocs' folder in XAMPP and open 'Windows PowerShell' and run the command 'php artisan migrate:fresh'.
6. Also, run the command 'php artisan schedule:run' to force running of the scheduler.
7. Start testing API by the following URLs:
/public/movies?genre=romance (Retrieving the movies by the genre)
/public/movies?popular|asc , /public/movies?popular|desc (according to the popularity ascending or descending respectively) 
/public/movies?rated|asc , /public/movies?rated|desc (according to the vote average ascending or descending respectively)
/public/movies?vote|asc , /public/movies?vote|desc (according to the vote count ascending or descending respectively)
