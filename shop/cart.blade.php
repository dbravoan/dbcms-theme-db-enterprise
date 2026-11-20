@extends('theme-db-enterprise::layouts.app')

@section('title', __('shop::public.cart_title') . ' - dbCMS Enterprise')

@section('content')
<div class="max-w-5xl mx-auto space-y-8">

    <div class="flex items-center justify-between border-b border-slate-800 pb-4">
        <div>
            <h1 class="text-2xl sm:text-3xl font-bold text-white flex items-center gap-2">
                <span class="text-indigo-400"><i class="fa-solid fa-bolt"></i></span>
                <span>{{ __('shop::public.cart_title') }}</span>
            </h1>
            <p class="text-xs text-slate-400 mt-1">{{ __('shop::public.cart_subtitle') }}</p>
        </div>
        <a href="{{ route('shop.index', ['market' => $currentMarket->code, 'locale' => $currentLocale]) }}" class="text-slate-400 hover:text-indigo-400 text-xs">
            &larr; {{ __('shop::public.continue_shopping') }}
        </a>
    </div>

    @if(empty($items))
        <div class="p-16 text-center bg-slate-900 border border-slate-800 rounded-2xl space-y-4">
            <span class="text-4xl block text-slate-600"><i class="fa-solid fa-building"></i></span>
            <h3 class="text-lg font-bold text-white">{{ __('shop::public.empty_cart') }}</h3>
            <p class="text-xs text-slate-400 max-w-sm mx-auto">{{ __('shop::public.empty_cart_description') }}</p>
            <a href="{{ route('shop.index', ['market' => $currentMarket->code, 'locale' => $currentLocale]) }}" class="px-5 py-2.5 bg-indigo-600 hover:bg-indigo-500 text-white rounded-lg text-xs font-semibold inline-block transition-colors shadow">{{ __('shop::public.explore_shop') }} &rarr;</a>
        </div>
    @else
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <div class="lg:col-span-2 bg-slate-900 border border-slate-800 rounded-2xl overflow-hidden">
                @include('shop::partials.cart-items', [
                    'items' => $items,
                    'currentMarket' => $currentMarket,
                    'currentLocale' => $currentLocale,
                ])
            </div>
            <div class="bg-slate-900 border border-slate-800 rounded-2xl p-6 space-y-4 h-fit">
                @include('shop::partials.cart-summary', [
                    'subtotal' => $subtotal,
                    'taxTotal' => $taxTotal,
                    'grandTotal' => $grandTotal,
                    'currentMarket' => $currentMarket,
                    'currentLocale' => $currentLocale,
                ])
            </div>
        </div>
    @endif

</div>
@endsection
