<?php

namespace App\Http\Controllers\AdminControllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MoviesController extends Controller
{
    public function insert(Request $request)
    {

        $posterImg = $request->file('poster');
        $poster =  uniqid() . '.' . $posterImg->getClientOriginalExtension();

        $bannerImg = $request->file('banner');
        $banner =  uniqid() . '.' . $bannerImg->getClientOriginalExtension();

        $movieFile = $request->file('movie_file');
        $movie = uniqid() . '.' . $movieFile->getClientOriginalExtension();

        DB::table('movies')->insert([
            'movie_name' => $request->movie_name,
            'movie_description' => $request->movie_desc,
            'category' => $request->category,
            'ott_category' => $request->ott_category,
            'movie_poster' => $poster,
            'movie_banner' => $banner,
            'movie_file' => $movie,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $posterImg->move(public_path('movies-imgs/posters/'), $poster);
        $bannerImg->move(public_path('movies-imgs/banners/'), $banner);
        $movieFile->move(public_path('movies/'), $movie);

        return "1";
    }

    public function getMoviesTable()
    {

        $movies = DB::table('movies')->get();
        $output = '';
        $count = 1;

        foreach ($movies as $movie) {
            $posterUrl = asset("movies-imgs/posters/{$movie->movie_poster}");
            $output .= '<tr>
            <td>' . $count . '</td>
            <td>
                <img src="' . $posterUrl . '" alt="">
            </td>
            <td class="movie-title-font">' . $movie->movie_name . '</td>
            <td class="movie-category-font">' . $movie->category . '</td>
            <td class="movie-category-font">' . $movie->ott_category . '</td>
            <td>' . $movie->created_at . '</td>
            <td>
                <p class="status delivered update-form pointer updatemovie_popup" data-update_id="' . $movie->id . '" id="update_btn">
                    Update
                </p>
                <br>
                <p class="status cancelled delete-btn pointer" data-delete_id="' . $movie->id . '" id="delete_btn">
                    Delete
                </p>
            </td>
        </tr>';
            $count++;
        }

        return $output;
    }

    public function getUpdateForm(Request $request)
    {
        $movie_id = $request->movie_id;
        $movie = DB::table('movies')->where('id', '=', $movie_id)->first();

        $categoryOptions = [
            'action' => 'Action',
            'advanture' => 'Advanture',
            'comady' => 'Comady',
            'drama' => 'Drama',
            'sifi' => 'Science Fiction',
            'fantasy' => 'Fantasy',
            'horror' => 'Horror',
            'thriller' => 'Thriller',
            'romantic' => 'Romantic'
        ];

        $category = '<select required name="category">';
        $category .= '<option disabled>Category</option>';

        foreach ($categoryOptions as $key => $value) {
            $selected = ($movie->category == $key) ? 'selected' : '';
            $category .= "<option value='$key' $selected>$value</option>";
        }

        $category .= '</select>';


        $ottCategoryOptions = [
            'all' => 'All',
            'slider' => 'Slider',
            'popular' => 'Popular',
        ];

        $ott_category = '<select required name="ott_category">';
        $ott_category .= '<option disabled>Ott Category</option>';

        foreach ($ottCategoryOptions as $key => $value) {
            $selected = ($movie->ott_category == $key) ? 'selected' : '';
            $ott_category .= "<option value='$key' $selected>$value</option>";
        }

        $ott_category .= '</select>';

        $output = '<form class="form" id="update-movie-form" enctype="multipart/form-data">
        '.csrf_field().'
        <div class="input-box">
            <label>Movie Name</label>
            <input type="text" placeholder="Movie name" name="movie_name" id="update-movie-name" value="' . $movie->movie_name . '" required />
            <span class="err" id="err-update-movie-name"></span>
        </div>
        <div class="input-box">
            <label>Description</label>
            <input type="text" placeholder="About the movie" name="movie_desc" id="update-movie-desc" value="' . $movie->movie_description . '" required />
            <span class="err" id="err-update-movie-desc"></span>
        </div>
        <div class="column">
            <div class="select-box">
                ' . $category . '
            </div>
            <div class="select-box">
                ' . $ott_category . '
            </div>
        </div>

        <div class="column">
            <div class="input-box">
                <label>Movie Poster</label>
                <input type="file" placeholder="Movie name" id="update-hero-pic" name="poster" />
                <span class="err" id="err-update-hero-pic"></span>
            </div>
            <div class="input-box">
                <label>Movie Banner</label>
                <input type="file" placeholder="Movie name" id="update-banner" name="banner" />
                <span class="err" id="err-update-banner"></span>
            </div>
        </div>

        <div class="input-box">
            <label>Movie File</label>
            <input type="file" placeholder="Movie name" id="update-movie-file" name="movie_file" />
            <span class="err" id="err-update-movie-file"></span>
            <label class="hideProgress" id="progressTitle_update">Progress of file uploading</label>
            <progress id="progressBar_update" class="hideProgress" value="0" max="100" style="width:100%;"></progress>
        </div>
        <button>Submit</button>
        </form>';

        return $output;
    }

    public function update(Request $request)
    {
        //latest data's id
        $update_id = $request->update_id;

        //old movie data for image handline
        $oldMovie = DB::table('movies')->where('id','=',$update_id)->first();
        
        if($request->hasFile('banner')){
            $oldBanner = $oldMovie->movie_banner;

            $newBanner = $request->file('banner');
            $newBannerName = uniqid() . '.' . $newBanner->getClientOriginalExtension();

            unlink(public_path('/movies-imgs/banners/' . $oldBanner . ''));

            $newBanner->move(public_path('/movies-imgs/banner/'),$newBannerName);
        }else{
            $newBannerName = $oldMovie->movie_banner;
        }

        if($request->hasFile('poster')){
            $oldPoster = $oldMovie->movie_poster;

            $newPoster = $request->file('poster');
            $newPosterName = uniqid() . '.' . $newPoster->getClientOriginalExtension();

            unlink(public_path('/movies-imgs/posters/' . $oldPoster . ''));

            $newPoster->move(public_path('/movies-imgs/posters/'),$newPosterName);
        }else{
            $newPosterName = $oldMovie->movie_poster;
        }

        if($request->hasFile('movie_file')){
            $oldMovieFile = $oldMovie->movie_file;

            $newMovieFile = $request->file('movie_file');
            $newMovieFileName = uniqid() . '.' . $newMovieFile->getClientOriginalExtension();

            unlink(public_path('movies/' . $oldMovieFile . ''));

            $newMovieFile->move(public_path('movies/'),$newMovieFileName);
        }else{
            $newMovieFileName = $oldMovie->movie_file;
        }

        DB::table('movies')->where('id','=',$update_id)->update([
            'movie_name' => $request->movie_name,
            'movie_description' => $request->movie_desc,
            'category' => $request->category,
            'ott_category' => $request->ott_category,
            'movie_poster' => $newPosterName,
            'movie_banner' => $newBannerName,
            'movie_file' => $newMovieFileName,
            'updated_at' => now(),
        ]);

        return true;
    }

    public function delete(Request $request){
        $delete_id = $request->delete_id;
        $movie = DB::table('movies')->where('id','=',$delete_id)->first();

        unlink(public_path('/movies-imgs/posters/' . $movie->movie_poster . ''));
        unlink(public_path('/movies-imgs/banners/' . $movie->movie_banner . ''));
        unlink(public_path('movies/' . $movie->movie_file . ''));

        DB::table('movies')->where('id','=',$delete_id)->delete();
        return true;
    }

    //it is for website aka with-login

    public function returnMoviesAccordingUi(){
        $sliderMovies = DB::table('movies')->where('ott_category','=','slider')->get();
        $popularMovies = DB::table('movies')->where('ott_category','=','popular')->get();
        $allMovies = DB::table('movies')->get();


        return view('with-login.index',['sliderMovies'=>$sliderMovies,'popularMovies'=>$popularMovies,'allMovies'=>$allMovies]);
    }

    public function returnSpecificMovie(String $movie_id = null){
        $isExsist = DB::table('movies')->where('id','=',$movie_id)->count();

        if(!$isExsist || $movie_id == null){
            return redirect()->route('user.home');
        }else{
            $movie_data = DB::table('movies')->where('id','=',$movie_id)->first();
            return view('with-login.play-page',['movie_data'=>$movie_data]);
        }
    }
}
