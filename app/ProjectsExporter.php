<?php

namespace App;

use App\Helpers\MetaFields;
use App\Repositories\ProjectRepository;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ProjectsExporter implements FromCollection, WithMapping, WithHeadings {

    use Exportable;

    const EXPORT_ATTRIBUTES = [
        MetaFields::STAGE_FIELD,
        MetaFields::CREATION_YEAR_FIELD,
        MetaFields::BLOCKCHAIN_TECH_FIELD,
        MetaFields::CLAIMED_STATUS_FIELD,
        MetaFields::LOGO_FIELD,
        MetaFields::ORGANIZATION_TYPE_FIELD,
        MetaFields::SHORT_DESCRIPTION_FIELD,
        MetaFields::LONG_DESCRIPTION_FIELD,
    ];

    public function collection()
    {
        $projectRepo = new ProjectRepository();

        return $projectRepo->getWpListingFields()->map(function ($post) {
            $fields = $post->fields;
            $fields = $this->geUnknownFieldValue($post, $fields, MetaFields::STAGE_FIELD);
            if (!Arr::exists($post->fields, MetaFields::CREATION_YEAR_FIELD)
                || empty($post->fields[MetaFields::CREATION_YEAR_FIELD])
                || !is_numeric($post->fields[MetaFields::CREATION_YEAR_FIELD])
            ) {
                $fields[MetaFields::CREATION_YEAR_FIELD] = 'unknown';
            }
            $fields = $this->geUnknownFieldValue($post, $fields, MetaFields::ORGANIZATION_TYPE_FIELD);
            $fields = $this->geUnknownFieldValue($post, $fields, MetaFields::TAGLINE_FIELD);
            $fields = $this->geUnknownFieldValue($post, $fields, MetaFields::SHORT_DESCRIPTION_FIELD);
            $fields = $this->geUnknownFieldValue($post, $fields, MetaFields::WEBSITE_FIELD);
            $fields = $this->geUnknownFieldValue($post, $fields, MetaFields::BLOCKCHAIN_TECH_FIELD);
            $fields = $this->geUnknownFieldValue($post, $fields, MetaFields::SERVICING_AREA_FIELD);
            $fields = $this->geUnknownFieldValue($post, $fields, MetaFields::LOGO_FIELD);
            $fields = $this->geUnknownFieldValue($post, $fields, MetaFields::CLAIMED_STATUS_FIELD);
            $post->main_category = Str::replaceFirst("&amp;", "&", $post->main_category);
            $post->fields = $fields;

            return $post;
        });
    }

    public function map($project): array
    {
        return [
            $project->post_title,
            $project->fields[MetaFields::TAGLINE_FIELD],
            $project->fields[MetaFields::SHORT_DESCRIPTION_FIELD],
            $project->fields[MetaFields::WEBSITE_FIELD],
            $this->reduceTaxonomiesToTermName($project->taxonomies)->implode(','),
            $this->replaceHtmlAmpersand($project->main_category),
            $this->filterSubcategories($project->taxonomies)->implode(','),
            $this->filterCountries($project->taxonomies)->implode(','),
            $project->fields[MetaFields::CREATION_YEAR_FIELD],
            $project->fields[MetaFields::STAGE_FIELD],
            $project->fields[MetaFields::LOGO_FIELD],
            $project->fields[MetaFields::SERVICING_AREA_FIELD],
            $this->getOrganizationTypes($project->fields[MetaFields::ORGANIZATION_TYPE_FIELD]),
            $this->getBlockchainUse($project->fields[MetaFields::BLOCKCHAIN_TECH_FIELD]),
            $this->getSdgs($project, MetaFields::SDG_FIELD),
            $this->getAuthorFullName($project->post_author),
            $project->post_modified,
        ];
    }

    public function headings(): array
    {
        return [
            'Project name',
            'Short description',
            'Long description',
            'Website',
            'Categories',
            'Main Category',
            'Subcategories',
            'Location',
            'Creation year',
            'Stage',
            'Logo URL',
            'Servicing area',
            'Organization type',
            'Used Blockchain Technology',
            'SDG',
            'Claimed Author',
            'Last edited',
        ];
    }

    /**
     * @param $post
     * @param $fields
     * @param string $property
     * @return array
     */
    private function geUnknownFieldValue($post, $fields, string $property): array
    {
        if (!Arr::exists($post->fields, $property)
            || empty($post->fields[$property])
        ) {
            $fields[$property] = 'unkown';
        }

        return $fields;
    }

    /**
     * @param Collection $taxonomies
     * @return Collection
     */
    private function reduceTaxonomiesToTermName(Collection $taxonomies): Collection
    {
        return $taxonomies->filter(function ($taxonomy) {
            return $taxonomy->taxonomy === 'listing-category';
        })->map(function ($taxonomy) {
            return $this->replaceHtmlAmpersand($taxonomy->term->name);
        });
    }

    /**
     * @param $value
     * @return string
     */
    private function getBlockchainUse($value): string
    {
        return $this->tryToImplodeFieldArray($value);
    }

    /**
     * @param $types
     * @return string
     */
    private function getOrganizationTypes($types): string
    {
        return $this->tryToImplodeFieldArray($types);
    }

    private function tryToImplodeFieldArray($value)
    {
        if (is_string($value)) {
            return $value;
        }
        if (is_array($value) && !empty($value)) {
            return implode(',', $value);
        }

        return 'unknown';
    }

    /**
     * @param string $string
     * @return string
     */
    private function replaceHtmlAmpersand(string $string): string
    {
        return Str::replaceFirst("&amp;", "&", $string);
    }

    /**
     * @param int $authorId
     * @return string
     */
    private function getAuthorFullName(int $authorId): string
    {
        $user = \Corcel\Model\User::find($authorId);

        return $user->first_name . ' ' . $user->last_name;
    }

    /**
     * @param $post
     * @param array $fields
     * @param $fieldName
     * @return string
     */
    private function getSdgs($post, $fieldName): string
    {
        $updatedFields = $this->geUnknownFieldValue($post, $post->fields, $fieldName);
        if (is_array($updatedFields[$fieldName])) {
            return implode(',', $updatedFields[$fieldName]);
        }

        return $updatedFields[$fieldName];
    }

    /**
     * @param Collection $taxonomies
     * @param $parent
     * @return Collection
     */
    private function filterSubcategories(Collection $taxonomies): Collection
    {
        return $taxonomies->filter(function ($taxonomy) {
            return $taxonomy->taxonomy === 'listing-category' && $taxonomy->parent != 0;
        });
    }

    /**
     * @param Collection $taxonomies
     * @return Collection
     */
    private function filterCountries(Collection $taxonomies): Collection
    {
        return $taxonomies->filter(function ($taxonomy) {
            return $taxonomy->taxonomy === 'location';
        });
    }

}
