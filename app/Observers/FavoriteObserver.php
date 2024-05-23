<?php

namespace App\Observers;

use App\Models\Favorite;
use App\Models\Product;

class FavoriteObserver
{
    /**
     * Handle the Favorite "created" event.
     *
     * @param  \App\Models\Favorite  $favorite
     * @return void
     */
    public function created(Favorite $favorite)
    {
        $this->updateFavoriteCount($favorite);
    }

    /**
     * Handle the Favorite "updated" event.
     *
     * @param  \App\Models\Favorite  $favorite
     * @return void
     */
    public function updated(Favorite $favorite)
    {
        //
    }

    /**
     * Handle the Favorite "deleted" event.
     *
     * @param  \App\Models\Favorite  $favorite
     * @return void
     */
    public function deleted(Favorite $favorite)
    {
        $this->updateFavoriteCount($favorite);
    }

    /**
     * Handle the Favorite "restored" event.
     *
     * @param  \App\Models\Favorite  $favorite
     * @return void
     */
    public function restored(Favorite $favorite)
    {
        //
    }

    /**
     * Handle the Favorite "force deleted" event.
     *
     * @param  \App\Models\Favorite  $favorite
     * @return void
     */
    public function forceDeleted(Favorite $favorite)
    {
        //
    }

    protected function updateFavoriteCount(Favorite $favorite)
    {
        $product = $favorite->product;
        $product->favorite_count = $product->favorites()->count();
        $product->save();
    }
}
