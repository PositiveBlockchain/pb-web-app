<?php


namespace App\Repositories;


use App\Helpers\MetaFields;
use App\Post;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;

class ProjectRepository {

    /**
     * @return Collection
     */
    public function getWpListingProjects(): Collection
    {
        if (Cache::has('projects'))
        {
            $projects = Cache::get('projects');
        }
        else
        {
            $projects = Post::type('listing')->published()->get();
            Cache::put('projects', $projects, now()->addMinutes(1));
        }

        return $projects;
    }

    /**
     * Get Wordpress posts with limits
     *
     * @param int $limit
     * @return mixed
     */
    public function getWpListingProjectsWithLimit(int $limit): Collection
    {
        return Post::type('listing')->published()->limit($limit)->get();
    }

    /**
     * @return Collection
     */
    public function getWpListingActiveProjects(): Collection
    {
        return Post::active()->get();
    }

    /**
     * @param int $limit
     * @return Collection
     */
    public function getWpListingMostActiveProjects(int $limit): Collection
    {
        if (Cache::has('projects-most-active'))
        {
            $projects = Cache::get('projects-most-active');
        }
        else
        {
            $projects = Post::mostActive($limit)->get();
            Cache::put('projects-most-active', $projects, now()->addMinutes(1));
        }

        return $projects;
    }

    /**
     * Filter the options field
     * and clean up the attributes
     *
     * @return Collection
     */
    public function getWpListingFields(): Collection
    {
        return $this->filterMetaFieldsWith(MetaFields::LP_OPTIONS_FIELD, $this->getWpListingProjects());
    }

    /**
     * Filter specifc meta fields
     *
     * @param string $filter
     * @param Collection $projects
     * @return Collection
     */
    public function filterMetaFieldsWith(string $filter, Collection $projects): Collection
    {
        return $projects->map(function ($post) use ($filter) {
            if ($post->meta->count() > 0)
            {
                $listingMetaValues = MetaFields::filterListingMetaFields($post, $filter);
                $post = MetaFields::appendMetaFields($listingMetaValues, $post);

                //remove all default meta data
                unset($post->meta);
            }

            return $post;
        });
    }
}
