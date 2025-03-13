<?php

namespace App\Infrastructure\Http\Controllers;

use App\Application\Interfaces\RedirectResolverInterface;
use App\Domain\Interfaces\LinkInterface;
use Illuminate\Http\RedirectResponse;

class RedirectController extends Controller
{
    public function resolve(LinkInterface $url, RedirectResolverInterface $redirectResolver): RedirectResponse
    {
        $redirect = $redirectResolver->resolve($url);

        if (!$redirect) {
            abort(404);
        }

        return redirect()->away($redirect->getLink());
    }
}
