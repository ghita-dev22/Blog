<x-default-layout :title="$post->exists() ? 'Modifier un post' : 'Créer un post'">
    <form action="{{ $post->exists() ? route('admin.update', ['post' => $post]) : route('admin.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @if ($post->exists())
            @method('PATCH')
        @endif

        <div class="space-y-12">
            <div class="border-b border-gray-900/10 pb-12">
                <h1 class="text-base font-semibold leading-7 text-gray-900">
                    {{ $post->exists() ? 'Modifier un post' : 'Créer un post' }}
                </h1>
                <p class="mt-1 text-sm leading-6 text-gray-600">Révélons au monde nos talents d'écrivains.</p>
                <div class="mt-10 space-y-8 md:w-2/3">
                    <x-input name="title" label="Titre" :value="$post->title" />
                    <x-input name="slug" label="Slug" :value="$post->slug" help="Laisser vide pour un slug auto. Si une valeur est renseignée, elle sera slugifiée avant d'être soumise à validation." />
                    <x-textarea name="content" label="Contenu du post">{{ $post->content }}</x-textarea>
                    <x-input name="thumbnail" type="file" label="Vignette" />
                    <x-select name="categorie_id" label="Catégorie" :value="$post->categorie_id" :list="$categories" />
                    <x-select name="tag_id" label="Etiquettes" :value="$post->tags" :list="$tags" multiple />
                </div>
            </div>
        </div>

        <div class="mt-6 flex items-center justify-end gap-x-6">
            <button type="submit" class="rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                {{ $post->exists() ? 'Mettre à jour' : 'Publier' }}
            </button>
        </div>
    </form>
</x-default-layout>
