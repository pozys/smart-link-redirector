<?php

namespace App\Infrastructure\Http\Controllers;

use App\Application\Interfaces\RedirectResolverInterface;
use App\Domain\Models\Link;
use Illuminate\Http\RedirectResponse;

class RedirectController extends Controller
{
    public function resolve(Link $link, RedirectResolverInterface $redirectResolver): RedirectResponse
    {
        $redirect = $redirectResolver->resolve($link);

        if (!$redirect) {
            abort(404);
        }

        return redirect()->away($redirect->getLink());
    }
}
