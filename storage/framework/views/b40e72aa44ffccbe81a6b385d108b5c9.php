<?php
    $slugNewsId = $slugNewsId ?? null;
    $slugInitialTitle = $slugInitialTitle ?? '';
    $slugInitialValue = $slugInitialValue ?? '';
    $slugIsEdit = filled($slugNewsId);
?>

<div class="sm:col-span-6" id="slug-assistant" data-edit="<?php echo e($slugIsEdit ? 'true' : 'false'); ?>" data-news-id="<?php echo e($slugNewsId); ?>" data-initial-title="<?php echo e($slugInitialTitle); ?>" data-initial-slug="<?php echo e($slugInitialValue); ?>">
    <div class="flex items-center justify-between gap-4">
        <?php if (isset($component)) { $__componentOriginalb2c43a998f3174877f99993c62e16bb4 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalb2c43a998f3174877f99993c62e16bb4 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.ui.label','data' => ['for' => 'slug','value' => 'Slug *']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('ui.label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['for' => 'slug','value' => 'Slug *']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalb2c43a998f3174877f99993c62e16bb4)): ?>
<?php $attributes = $__attributesOriginalb2c43a998f3174877f99993c62e16bb4; ?>
<?php unset($__attributesOriginalb2c43a998f3174877f99993c62e16bb4); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalb2c43a998f3174877f99993c62e16bb4)): ?>
<?php $component = $__componentOriginalb2c43a998f3174877f99993c62e16bb4; ?>
<?php unset($__componentOriginalb2c43a998f3174877f99993c62e16bb4); ?>
<?php endif; ?>
        <label class="inline-flex items-center gap-2 text-sm text-gray-600">
            <input id="slug-manual-toggle" name="slug_manual" value="1" type="checkbox" <?php if(old('slug_manual')): echo 'checked'; endif; ?> class="rounded border-gray-300 text-gray-900 shadow-sm focus:ring-gray-900">
            <span>Tentukan slug sendiri</span>
        </label>
    </div>
    <div class="mt-2">
        <?php if (isset($component)) { $__componentOriginal65bd7e7dbd93cec773ad6501ce127e46 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal65bd7e7dbd93cec773ad6501ce127e46 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.ui.input','data' => ['id' => 'slug','name' => 'slug','type' => 'text','value' => ''.e($slugInitialValue).'','required' => true,'readonly' => true,'placeholder' => 'article-url-slug','class' => 'font-mono text-sm']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('ui.input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['id' => 'slug','name' => 'slug','type' => 'text','value' => ''.e($slugInitialValue).'','required' => true,'readonly' => true,'placeholder' => 'article-url-slug','class' => 'font-mono text-sm']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal65bd7e7dbd93cec773ad6501ce127e46)): ?>
<?php $attributes = $__attributesOriginal65bd7e7dbd93cec773ad6501ce127e46; ?>
<?php unset($__attributesOriginal65bd7e7dbd93cec773ad6501ce127e46); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal65bd7e7dbd93cec773ad6501ce127e46)): ?>
<?php $component = $__componentOriginal65bd7e7dbd93cec773ad6501ce127e46; ?>
<?php unset($__componentOriginal65bd7e7dbd93cec773ad6501ce127e46); ?>
<?php endif; ?>
    </div>
    <p class="mt-1 text-sm text-gray-500">Slug dibuat otomatis setelah Anda berhenti mengetik judul.</p>
    <p id="slug-status" class="mt-2 hidden rounded-md px-3 py-2 text-sm" role="status" aria-live="polite"></p>
    <div id="slug-edit-warning" class="mt-3 hidden rounded-md border border-amber-200 bg-amber-50 p-3 text-sm text-amber-900" role="alert">
        <p>Anda telah mengubah judul berita, ingin mengubah juga slug ini?</p>
        <div class="mt-2 flex flex-wrap gap-2">
            <button id="slug-confirm-change" type="button" class="inline-flex items-center rounded-md border border-amber-800 bg-amber-700 px-3 py-1.5 text-sm font-semibold text-white shadow-sm hover:bg-amber-800 focus:outline-none focus:ring-2 focus:ring-amber-700 focus:ring-offset-1">Ya ganti</button>
            <button id="slug-keep-change" type="button" class="inline-flex items-center rounded-md border border-amber-400 bg-white px-3 py-1.5 text-sm font-semibold text-amber-900 shadow-sm hover:bg-amber-100 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:ring-offset-1">Tetap pertahankan slug lama</button>
        </div>
    </div>
    <div id="slug-recommendations" class="mt-3 hidden" aria-live="polite">
        <p class="text-sm font-medium text-gray-700">Rekomendasi slug:</p>
        <div id="slug-recommendation-list" class="mt-2 flex flex-wrap gap-2"></div>
    </div>
    <input type="hidden" id="slug-change-confirmed" name="slug_change_confirmed" value="<?php echo e(old('slug_change_confirmed', '0')); ?>">
</div>

<?php $__env->startPush('scripts'); ?>
<script>
document.addEventListener('DOMContentLoaded', () => {
    const assistant = document.getElementById('slug-assistant');
    if (!assistant) return;

    const titleInput = document.getElementById('title');
    const slugInput = document.getElementById('slug');
    const manualToggle = document.getElementById('slug-manual-toggle');
    const warning = document.getElementById('slug-edit-warning');
    const status = document.getElementById('slug-status');
    const recommendations = document.getElementById('slug-recommendations');
    const recommendationList = document.getElementById('slug-recommendation-list');
    const confirmedInput = document.getElementById('slug-change-confirmed');
    const isEdit = assistant.dataset.edit === 'true';
    const initialTitle = assistant.dataset.initialTitle || '';
    const initialSlug = assistant.dataset.initialSlug || '';
    const endpoint = <?php echo json_encode(route('admin.news.slug-suggestions'), 15, 512) ?>;
    let requestController = null;
    let requestSequence = 0;
    let debounceTimer = null;
    let pendingSlug = '';

    const hideRecommendations = () => {
        recommendations.classList.add('hidden');
        recommendationList.replaceChildren();
    };

    const hideStatus = () => {
        status.className = 'mt-2 hidden rounded-md px-3 py-2 text-sm';
        status.textContent = '';
    };

    const showStatus = (available) => {
        status.className = available
            ? 'mt-2 rounded-md bg-emerald-50 px-3 py-2 text-sm text-emerald-700'
            : 'mt-2 rounded-md bg-rose-50 px-3 py-2 text-sm text-rose-700';
        status.textContent = available ? 'Slug aman digunakan.' : 'Slug sudah digunakan. Pilih salah satu rekomendasi.';
    };

    const showRecommendations = (items) => {
        recommendationList.replaceChildren();
        items.slice(0, 3).forEach((item) => {
            const button = document.createElement('button');
            button.type = 'button';
            button.textContent = item;
            button.className = 'rounded-md border border-gray-300 bg-white px-3 py-1.5 font-mono text-xs text-gray-700 hover:border-gray-900 hover:text-gray-900';
            button.addEventListener('click', () => {
                slugInput.value = item;
                showStatus(true);
                hideRecommendations();
            });
            recommendationList.appendChild(button);
        });
        recommendations.classList.toggle('hidden', items.length === 0);
    };

    const applySuggestion = (suggestion) => {
        if (!suggestion.slug) return;
        if (isEdit && suggestion.slug !== initialSlug && titleInput.value !== initialTitle && !manualToggle.checked && confirmedInput.value !== '1') {
            pendingSlug = suggestion.slug;
            warning.classList.remove('hidden');
            return;
        }
        slugInput.value = suggestion.slug;
        warning.classList.add('hidden');
    };

    const requestSuggestion = async (value, force = false) => {
        const title = value.trim();
        if (!title) {
            if (!isEdit || force) slugInput.value = '';
            hideRecommendations();
            hideStatus();
            return;
        }

        requestController?.abort();
        requestController = new AbortController();
        const sequence = ++requestSequence;
        const params = new URLSearchParams({ title });
        if (assistant.dataset.newsId) params.set('ignore', assistant.dataset.newsId);

        try {
            const response = await fetch(`${endpoint}?${params}`, {
                headers: { Accept: 'application/json' },
                signal: requestController.signal,
            });
            if (!response.ok) throw new Error('Slug request failed');
            const suggestion = await response.json();
            if (sequence !== requestSequence) return;
            if (manualToggle.checked) {
                showStatus(suggestion.available);
                if (!suggestion.available) showRecommendations(suggestion.suggestions || []);
                else hideRecommendations();
            } else {
                hideStatus();
                hideRecommendations();
                applySuggestion(suggestion);
            }
        } catch (error) {
            if (error.name !== 'AbortError') console.error(error);
        }
    };

    const scheduleSuggestion = () => {
        clearTimeout(debounceTimer);
        debounceTimer = setTimeout(() => requestSuggestion(manualToggle.checked ? slugInput.value : titleInput.value), 500);
    };

    titleInput.addEventListener('input', scheduleSuggestion);
    slugInput.addEventListener('input', () => {
        if (!manualToggle.checked) {
            manualToggle.checked = true;
            slugInput.readOnly = false;
        }
        scheduleSuggestion();
    });
    manualToggle.addEventListener('change', () => {
        slugInput.readOnly = !manualToggle.checked;
        if (manualToggle.checked) {
            warning.classList.add('hidden');
            confirmedInput.value = '0';
            if (slugInput.value) scheduleSuggestion();
        } else {
            hideStatus();
            hideRecommendations();
            requestSuggestion(titleInput.value);
        }
    });
    document.getElementById('slug-confirm-change').addEventListener('click', () => {
        slugInput.value = pendingSlug;
        confirmedInput.value = '1';
        pendingSlug = '';
        warning.classList.add('hidden');
    });
    document.getElementById('slug-keep-change').addEventListener('click', () => {
        pendingSlug = '';
        confirmedInput.value = '0';
        warning.classList.add('hidden');
        slugInput.value = initialSlug;
    });

    slugInput.readOnly = !manualToggle.checked;
    if (!isEdit && titleInput.value && !slugInput.value) requestSuggestion(titleInput.value);
});
</script>
<?php $__env->stopPush(); ?>
<?php /**PATH C:\Users\Lenovo\Documents\ENT News\news\resources\views/admin/news/_slug-assistant.blade.php ENDPATH**/ ?>