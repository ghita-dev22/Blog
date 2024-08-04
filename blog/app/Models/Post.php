<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Post extends Model
{
    use HasFactory;
    protected $guarded = ['id', 'created_at', 'updated_at'];
    protected $with =[
        'categorie',
        'tags'
];
    public function getRouteKeyName()
    {
        return 'slug';
    }
    public function scopeFilters(Builder $query, array $filters): void
    {
        if (isset($filters['search'])) {
            $query->where(fn (Builder $query) => $query
                ->where('title', 'LIKE', '%' . $filters['search'] . '%')
                ->orWhere('content', 'LIKE', '%' . $filters['search'] . '%')
            );
        }

        if (isset($filters['categorie'])) {
            $query->where(
                'categorie_id', $filters['categorie']->id ?? $filters['categorie']
            );
        }

        if (isset($filters['tag'])) {
            $query->whereRelation(
                'tags', 'tags.id', $filters['tag']->id ?? $filters['tag']
            );
        }
    }
    public function categorie(){
        return $this->belongsTo(Categorie::class);
    }
    public function tags(){
        return $this->belongsToMany(Tag::class);
    }
    public function comments (){
        return $this->hasMany(Comment::class)->latest();
    }
    public function exists(){
        return (bool)$this->id;
    }
}
