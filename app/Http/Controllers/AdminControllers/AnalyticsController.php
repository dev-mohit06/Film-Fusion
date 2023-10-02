<?php

namespace App\Http\Controllers\AdminControllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AnalyticsController extends Controller
{

    public function loadAnalytics()
    {
        $distinctMovieIds = DB::table('likes_and_dislikes')->select('movie_id')->distinct()->pluck('movie_id');

        $moviesData = [];
        $index = 0;
        foreach ($distinctMovieIds as $movie_id) {
            $data = DB::table('likes_and_dislikes')
                ->select('movies.id', 'movies.movie_poster', 'movies.movie_name', 'movies.category', DB::raw('SUM(likes) as likes'), DB::raw('SUM(dislikes) as dislikes'))
                ->join('movies', 'likes_and_dislikes.movie_id', '=', 'movies.id')
                ->where('likes_and_dislikes.movie_id', $movie_id)
                ->groupBy('movies.id', 'movies.movie_poster', 'movies.movie_name', 'movies.category')
                ->first();
            $moviesData[$index] = $data;
            $index++;
        }

        $output = '';
        $count = 1;
        foreach ($moviesData as $movie) {
            $imgUrl = asset("movies-imgs/posters/{$movie->movie_poster}");
            $output .= '<tr>
            <td>' . $count . '</td>
            <td>
                <img src="' . $imgUrl . '" alt="">
            </td>
            <td class="movie-title-font">' . $movie->movie_name . '</td>
            <td>' . $movie->category . '</td>
            <td>
                <div class="count-container">
                    <span class="material-symbols-rounded active">thumb_up</span>
                    <p>' . $movie->likes . '</p>
                </div>
            </td>
            <td>
                <div class="count-container">
                    <span class="material-symbols-rounded danger">thumb_down</span>
                    <p>' . $movie->dislikes . '</p>
                </div>
            </td>
            </tr>';
            $count++;
        }

        return $output;
    }

    //it is for website aka with-login
    public function getAnalytics(Request $request)
    {
        $movie_id = $request->movie_id;

        $likeCount = 0;
        $disLikeCount = 0;

        $movie_data = DB::table('likes_and_dislikes')->where('movie_id', '=', $movie_id)->get();

        foreach ($movie_data as $movie_data) {
            $likeCount += $movie_data->likes;
            $disLikeCount += $movie_data->dislikes;
        }

        $analytics = [
            'likes' => $likeCount,
            'dislikes' => $disLikeCount,
        ];

        $isUserRespond = DB::table('likes_and_dislikes')->where('user_id', '=', session()->get('id'))->where("movie_id", "=", $movie_id)->count();

        if ($isUserRespond) {
            $current_user_prefrence = DB::table('likes_and_dislikes')->where('movie_id', '=', $movie_id)->where('user_id', '=', session()->get('id'))->first();
            $userLikes = $current_user_prefrence->likes;
            $userDisLikes = $current_user_prefrence->dislikes;

            if ($userLikes == 0 && $userDisLikes == 0) {
                $user_prefrence = [
                    'is_liked' => 0,
                    'is_disliked' => 0,
                ];
            } else if ($userLikes == 1 && $userDisLikes == 0) {
                $user_prefrence = [
                    'is_liked' => 1,
                    'is_disliked' => 0,
                ];
            } else if ($userLikes == 0 && $userDisLikes == 1) {
                $user_prefrence = [
                    'is_liked' => 0,
                    'is_disliked' => 1,
                ];
            }
        } else {
            $user_prefrence = [
                'is_liked' => 0,
                'is_disliked' => 0,
            ];
        }

        return response()->json([
            'analytics' => $analytics,
            'user_preference' => $user_prefrence,
            'is_respond' => $isUserRespond,
        ]);
    }

    public function giveAnalytics(Request $request)
    {
        $movie_id = $request->movie_id;
        $btn = $request->btn;
        $user_id = session()->get('id');

        $movie_data = DB::table('likes_and_dislikes')->where('movie_id', '=', $movie_id)->where('user_id', '=', $user_id)->first();

        if ($movie_data) {
            if ($btn == "like") {
                if ($movie_data->dislikes) {
                    DB::table('likes_and_dislikes')->where('user_id', '=', $user_id)->where('movie_id', '=', $movie_id)->update([
                        'likes' => 1,
                        'dislikes' => 0,
                        'updated_at' => now(),
                    ]);
                } else {
                    if ($movie_data->likes) {
                        DB::table('likes_and_dislikes')->where('user_id', '=', $user_id)->where('movie_id', '=', $movie_id)->update([
                            'likes' => 0,
                            'updated_at' => now(),
                        ]);
                    } else {
                        DB::table('likes_and_dislikes')->where('user_id', '=', $user_id)->where('movie_id', '=', $movie_id)->update([
                            'likes' => 1,
                            'updated_at' => now(),
                        ]);
                    }
                }
            } else {
                if ($movie_data->likes) {
                    DB::table('likes_and_dislikes')->where('user_id', '=', $user_id)->where('movie_id', '=', $movie_id)->update([
                        'likes' => 0,
                        'dislikes' => 1,
                        'updated_at' => now(),
                    ]);
                } else {
                    if ($movie_data->dislikes) {
                        DB::table('likes_and_dislikes')->where('user_id', '=', $user_id)->where('movie_id', '=', $movie_id)->update([
                            'dislikes' => 0,
                            'updated_at' => now(),
                        ]);
                    } else {
                        DB::table('likes_and_dislikes')->where('user_id', '=', $user_id)->where('movie_id', '=', $movie_id)->update([
                            'dislikes' => 1,
                            'updated_at' => now(),
                        ]);
                    }
                }
            }
        } else {
            if ($btn == "like") {
                DB::table('likes_and_dislikes')->insert([
                    'user_id' => $user_id,
                    'movie_id' => $movie_id,
                    'likes' => 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            } else {
                DB::table('likes_and_dislikes')->insert([
                    'user_id' => $user_id,
                    'movie_id' => $movie_id,
                    'dislikes' => 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}
