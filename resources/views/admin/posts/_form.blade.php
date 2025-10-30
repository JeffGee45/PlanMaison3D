<div class="row">
    <div class="col-md-8">
        <div class="mb-3">
            <label for="title" class="form-label">Titre</label>
            <input type="text" class="form-control" id="title" name="title" value="{{ old('title', $post->title ?? '') }}" required>
        </div>
        <div class="mb-3">
            <label for="content" class="form-label">Contenu</label>
            <textarea class="form-control" id="content" name="content" rows="10" required>{{ old('content', $post->content ?? '') }}</textarea>
        </div>
    </div>
    <div class="col-md-4">
        <div class="mb-3">
            <label for="category_id" class="form-label">Catégorie</label>
            <select class="form-select" id="category_id" name="category_id">
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" @selected(old('category_id', $post->category_id ?? '') == $category->id)>{{ $category->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label for="tags" class="form-label">Tags</label>
            <select class="form-select" id="tags" name="tags[]" multiple>
                @foreach($tags as $tag)
                    <option value="{{ $tag->id }}" @selected(in_array($tag->id, old('tags', $post->tags->pluck('id')->all() ?? [])))>{{ $tag->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label for="image" class="form-label">Image</label>
            <input class="form-control" type="file" id="image" name="image">
            @if(isset($post) && $post->image)
                <img src="{{ asset('storage/' . $post->image) }}" alt="" class="img-fluid mt-2">
            @endif
        </div>
        <div class="mb-3">
            <label for="status" class="form-label">Statut</label>
            <select class="form-select" id="status" name="status">
                <option value="draft" @selected(old('status', $post->status ?? '') == 'draft')>Brouillon</option>
                <option value="published" @selected(old('status', $post->status ?? '') == 'published')>Publié</option>
            </select>
        </div>
    </div>
</div>
