@extends('theme-db-enterprise::layouts.app')

@php
    $trans = public_translation($post);
    $marketCode = $currentMarket?->code ?? 'es';
    $markdownRenderer = app(\DbCms\Core\Services\Media\MarkdownRendererService::class);
    $renderedBody = $trans ? $markdownRenderer->render($trans->content) : '';
@endphp

@section('title', ($trans->meta_title ?? $trans->title ?? __('Artículo')) . ' - dbCMS Enterprise')
@section('meta_description', $trans->meta_description ?? $trans->summary ?? '')

@section('content')
<div class="max-w-4xl mx-auto space-y-12" @if(!empty($post)) data-cms-edit-url="{{ route('admin.blog.posts.edit', $post->id) }}" data-cms-edit-label="Editar Artículo" @endif>

    <!-- Breadcrumb Component -->
    @include('components.breadcrumbs', ['trail' => $breadcrumbs ?? []])

    <!-- Article Header -->
    <header class="space-y-6 border-b border-slate-800 pb-10">
        <div class="flex items-center gap-3 text-xs font-semibold text-indigo-400">
            <span class="px-2.5 py-1 rounded bg-indigo-500/10 border border-indigo-500/30">
                {{ public_translation($post->category)?->name ?? 'Enterprise Whitepaper' }}
            </span>
            <span>&bull;</span>
            <span class="text-slate-400">{{ ($post->published_at ?? now())->copy()->locale(app()->getLocale())->isoFormat('LL') }}</span>
            <span>&bull;</span>
            <span class="text-slate-400"><i class="fa-solid fa-clock mr-1"></i> {{ $post->reading_time_minutes }} min read</span>
        </div>

        <h1 class="text-3xl sm:text-5xl font-bold text-white tracking-tight leading-tight">
            {{ $trans->title ?? '' }}
        </h1>

        @if($trans->summary)
            <p class="text-base sm:text-lg text-slate-300 border-l-2 border-indigo-500 pl-4 py-1 leading-relaxed">
                {{ $trans->summary }}
            </p>
        @endif

        <div class="flex items-center space-x-3 pt-2 text-xs text-slate-400">
            <div class="w-9 h-9 rounded-lg bg-indigo-600/20 border border-indigo-500/40 flex items-center justify-center text-indigo-300 font-bold">
                {{ substr($post->author->name ?? 'E', 0, 1) }}
            </div>
            <div>
                <span class="text-white font-semibold block">{{ $post->author->name ?? 'Equipo dbCMS Enterprise' }}</span>
                <span class="text-slate-500 text-[11px]">Arquitectura de Sistemas & Gobernanza</span>
            </div>
        </div>
    </header>

    <!-- Featured Image -->
    @if($post->featured_image)
        <div class="rounded-2xl overflow-hidden border border-slate-800 shadow-2xl">
            <img src="{{ $post->featured_image }}" alt="{{ $trans->title ?? '' }}" class="w-full max-h-[480px] object-cover" loading="eager" fetchpriority="high" decoding="async">
        </div>
    @endif

    <!-- Article Body & Modular Sections -->
    @if(isset($renderedSections) && count($renderedSections) > 0)
        <div class="space-y-10">
            @foreach($renderedSections as $sectionHtml)
                <div>
                    {!! $sectionHtml !!}
                </div>
            @endforeach
        </div>
    @else
        <article class="bg-slate-900 border border-slate-800 rounded-2xl p-8 sm:p-12 text-slate-200 leading-relaxed space-y-6 max-w-none text-sm">
            {!! $renderedBody !!}
        </article>
    @endif

    @include('blog::partials.comments')

</div>

@endsection
