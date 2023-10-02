<?php

namespace Database\Seeders;

use App\Models\Movie;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MovieSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $movies = [
            [
                'movie_name' => 'Fast X',
                'movie_description' => 'Plot. Dominic Toretto and his team are requested by the Agency to steal a computer chip during its transit in Rome, Italy. Dom and his wife Letty Ortiz stay behind with his son Brian',
                'category' => 'action',
                'ott_category' => 'slider',
                'movie_poster' => '65133e221b3f6.jpg',
                'movie_banner' => '65133e221b3fe.jpg',
                'movie_file' => '6515c69bbb6e8.mp4',
            ],
            [
                'movie_name' => 'Spectre',
                'movie_description' => 'SPECTRE (Special Executive for Counter-intelligence, Terrorism, Revenge and Extortion) is a fictional organisation featured in the James Bond novels by Ian Fleming, as well as the films and video games based on those novels.',
                'category' => 'action',
                'ott_category' => 'popular',
                'movie_poster' => '65133f46c0086.jpg',
                'movie_banner' => '65133f46c008c.jpg',
                'movie_file' => '65133f46c008d.mp4',
            ],
            [
                'movie_name' => 'The Flash Armageddon',
                'movie_description' => 'Storyline. A powerful alien threat arrives on Earth under mysterious circumstances and Barry, Iris and the rest of Team Flash are pushed to their limits in a desperate battle to save the world.',
                'category' => 'sifi',
                'ott_category' => 'popular',
                'movie_poster' => '651344c9e3bb6.jpg',
                'movie_banner' => '651344c9e3bbd.jpeg',
                'movie_file' => '651344c9e3bbf.mp4',
            ],
            [
                'movie_name' => 'Spider-Man: No Way Home',
                'movie_description' => 'Peter Parker\'s secret identity is revealed to the entire world. Desperate for help, Peter turns to Doctor Strange to make the world forget that he is Spider-Man. The spell goes horribly wrong and shatters the multiverse, bringing in monstrous villains that could destroy the world. The Multiverse Unleashed.',
                'category' => 'sifi',
                'ott_category' => 'popular',
                'movie_poster' => '6513465a05bc3.jpg',
                'movie_banner' => '6513465a05bcd.jpg',
                'movie_file' => '6513465a05bd0.mp4',
            ],
            [
                'movie_name' => 'Mission: Impossible - Dead Reckoning Part One',
                'movie_description' => 'In Mission: Impossible - Dead Reckoning Part One, Ethan Hunt (Tom Cruise) and his IMF team embark on their most dangerous mission yet: To track down a terrifying new weapon that threatens all of humanity before it falls into the wrong hands.',
                'category' => 'action',
                'ott_category' => 'slider',
                'movie_poster' => '6513f414302e5.jpg',
                'movie_banner' => '6513f414302eb.jpg',
                'movie_file' => '6515a9a0d4fde.mp4',
            ],
            [
                'movie_name' => 'Oppenheimer',
                'movie_description' => 'Based on the 2005 biography American Prometheus by Kai Bird and Martin J. Sherwin, the film chronicles the career of Oppenheimer, with the story predominantly focusing on his studies, his direction of the Manhattan Project during World War II, and his eventual fall from grace due to his 1954 security hearing.',
                'category' => 'drama',
                'ott_category' => 'popular',
                'movie_poster' => '651490d8321a9.jpg',
                'movie_banner' => '651490d8321b1.jpeg',
                'movie_file' => '651562e8a4b5f.mp4',
            ],
            [
                'movie_name' => 'The Invisible Man',
                'movie_description' => 'The Invisible Man, science-fiction novel by H.G. Wells, published in 1897. The story concerns the life and death of a scientist named Griffin who has gone mad. Having learned how to make himself invisible, Griffin begins to use his invisibility for nefarious purposes, including murder.',
                'category' => 'thriller',
                'ott_category' => 'popular',
                'movie_poster' => '6515047c8ec3d.jpeg',
                'movie_banner' => '6515047c8ec46.jpeg',
                'movie_file' => '6515047c8ec48.mp4',
            ],
            [
                'movie_name' => 'Jumanji: Welcome to the Jungle',
                'movie_description' => 'The story focuses on a group of teenagers who come across Jumanji, now transformed into a video game twenty-two years after the events of the 1995 film. They find themselves trapped in the game as a set of adult avatars, seeking to complete a quest alongside another player who has been trapped since 1996.',
                'category' => 'comady',
                'ott_category' => 'popular',
                'movie_poster' => '6515aa0ca0492.jpg',
                'movie_banner' => '6515aa0ca0499.jpg',
                'movie_file' => '6515aa0ca049c.mp4',
            ],
            [
                'movie_name' => 'Animal',
                'movie_description' => 'Animal is an upcoming Indian Hindi language action thriller film co-written, edited and directed by Sandeep Reddy Vanga and produced by T-Series and Cine1 Studios. The film stars Ranbir Kapoor, Anil Kapoor, Bobby Deol, Rashmika Mandanna and Tripti Dimri.',
                'category' => 'thriller',
                'ott_category' => 'slider',
                'movie_poster' => '6515c9d70c7d0.jpg',
                'movie_banner' => '6515c94a9d687.jpg',
                'movie_file' => '6515c94a9d689.mp4',
            ],
        ];

        foreach ($movies as $movie) {
            Movie::factory()->create($movie);
        }
    }
}
