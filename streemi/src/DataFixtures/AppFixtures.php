<?php
namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\Comment;
use App\Entity\Episode;
use App\Entity\Language;
use App\Entity\Media;
use App\Entity\Movie;
use App\Entity\Playlist;
use App\Entity\PlaylistMedia;
use App\Entity\Season;
use App\Entity\Serie;
use App\Entity\Subscription;
use App\Entity\SubscriptionHistory;
use App\Entity\User;
use App\Enum\CommentStatusEnum;
use App\Enum\UserStatusEnum;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $this->loadUsers($manager);
        $this->loadLanguages($manager);
        $this->loadCategories($manager);
        $this->loadMedias($manager);
        $this->loadMovies($manager);
        $this->loadSeries($manager);
        $this->loadSeasons($manager);
        $this->loadEpisodes($manager);
        $this->loadPlaylists($manager);
        $this->loadPlaylistMedias($manager);
        $this->loadComments($manager);
        $this->loadSubscriptions($manager);
        $this->loadSubscriptionHistories($manager);
    }

    private function loadUsers(ObjectManager $manager)
    {
        $user = new User();
        $user->setEmail('johndoe@gmail.com');
        $user->setUsername('johndoe');
        $user->setPassword('johndoe');
        $user->setRoles(['ROLE_USER']);
        $user->setStatus(UserStatusEnum::ACTIVE);
        $manager->persist($user);
    }

    private function loadLanguages(ObjectManager $manager)
    {
        $languages = ['English', 'French', 'Spanish', 'German', 'Italian', 'Portuguese', 'Russian', 'Chinese', 'Japanese', 'Korean'];
        foreach ($languages as $language) {
            $lang = new Language();
            $lang->setName($language);
            $manager->persist($lang);
        }
    }

    private function loadCategories(ObjectManager $manager)
    {
        $categories = ['Action', 'Adventure', 'Comedy', 'Crime', 'Drama', "Horror"];
        foreach ($categories as $category) {
            $cat = new Category();
            $cat->setName($category);
            $manager->persist($cat);
        }
    }

    private function loadMedias(ObjectManager $manager)
    {
        $media = new Media();
        $media->setMedia($manager->getRepository(Movie::class)->findOneBy(['title' => 'The Matrix']));
        $media->setMedia($manager->getRepository(Serie::class)->findOneBy(['title' => 'Monster']));
        $manager->persist($media);
    }

    private function loadMovies(ObjectManager $manager)
    {
        $movie = new Movie();
        $movie->setTitle('The Matrix');
        $movie->setReleaseDate(new \DateTime('1999-03-31'));
        $movie->setDuration(136);
        $movie->setLanguage($manager->getRepository(Language::class)->findOneBy(['name' => 'English']));
        $movie->setCategory($manager->getRepository(Category::class)->findOneBy(['name' => 'Action']));
        $movie->setCover('https://cdn-images.dzcdn.net/images/cover/c47dfdf89e2e081e0e9914e6cee2fbfc/0x1900-000000-80-0-0.jpg');
        $movie->setTrailer('https://www.youtube.com/watch?v=vKQi3bBA1y8');
        $manager->persist($movie);
    }
    
    private function loadPlaylists(ObjectManager $manager)
    {
        $playlist = new Playlist();
        $playlist->setName('My Playlist');
        $playlist->setUser($manager->getRepository(User::class)->findOneBy(['username' => 'johndoe']));
        $manager->persist($playlist);
    }

    private function loadPlaylistMedias(ObjectManager $manager)
    {
        $playlistMedia = new PlaylistMedia();
        $playlistMedia->setPlaylist($manager->getRepository(Playlist::class)->findOneBy(['name' => 'My Playlist']));
        $playlistMedia->setMedia($manager->getRepository(Media::class)->findOneBy(['title' => 'The Matrix']));
        $manager->persist($playlistMedia);
    }

    private function loadSeries(ObjectManager $manager)
    {
        $serie = new Serie();
        $serie->setTitle('Monster');
        $serie->setReleaseDate(new \DateTime('2004-10-12'));
        $serie->setDuration(0);
        $serie->setLanguage($manager->getRepository(Language::class)->findOneBy(['name' => 'Japanese']));
        $serie->setCategory($manager->getRepository(Category::class)->findOneBy(['name' => 'Thriller']));
        $serie->setCover('https://upload.wikimedia.org/wikipedia/en/2/2d/Monster_%28manga_-_promo_image%29.jpg');
        $serie->setTrailer('https://www.youtube.com/watch?v=vKQi3bBA1y8');
        $manager->persist($serie);
    }

    private function loadSeasons(ObjectManager $manager)
    {
        $season = new Season();
        $season->setSerie($manager->getRepository(Serie::class)->findOneBy(['media' => 'The Matrix']));
        $season->setNumber(1);
        $manager->persist($season);
    }

    private function loadEpisodes(ObjectManager $manager)
    {
        $episode = new Episode();
        $episode->setSeason($manager->getRepository(Season::class)->findOneBy(['number' => 1]));
        $episode->setNumber(1);
        $episode->setTitle('The Matrix');
        $episode->setReleaseDate(new \DateTime('1999-03-31'));
        $episode->setDuration(24);
        $episode->setLanguage($manager->getRepository(Language::class)->findOneBy(['name' => 'English']));
        $episode->setCategory($manager->getRepository(Category::class)->findOneBy(['name' => 'Action']));
        $episode->setCover('https://cdn-images.dzcdn.net/images/cover/c47dfdf89e2e081e0e9914e6cee2fbfc/0x1900-000000-80-0-0.jpg');
        $manager->persist($episode);
    }

    private function loadComments(ObjectManager $manager)
    {
        $comment = new Comment();
        $comment->setUser($manager->getRepository(User::class)->findOneBy(['username' => 'johndoe']));
        $comment->setMedia($manager->getRepository(Media::class)->findOneBy(['title' => 'The Matrix']));
        $comment->setContent('This is a great movie!');
        $comment->setStatus(CommentStatusEnum::PUBLISHED);
        $manager->persist($comment);
    }

    private function loadSubscriptions(ObjectManager $manager)
    {
        $subscription = new Subscription();
        $subscription->setName('Basic');
        $subscription->setPrice(0);
        $subscription->setDuration(30);
        $subscription->setNbMedias(5);
        $manager->persist($subscription);
    }

    private function loadSubscriptionHistories(ObjectManager $manager)
    {
        $subscriptionHistory = new SubscriptionHistory();
        $subscriptionHistory->setUser($manager->getRepository(User::class)->findOneBy(['username' => 'johndoe']));
        $subscriptionHistory->setSubscription($manager->getRepository(Subscription::class)->findOneBy(['name' => 'Basic']));
        $subscriptionHistory->setStartDate(new \DateTime('2021-01-01'));
        $subscriptionHistory->setEndDate(new \DateTime('2021-01-31'));
        $manager->persist($subscriptionHistory);
    }

    $manager->flush();
    
}
