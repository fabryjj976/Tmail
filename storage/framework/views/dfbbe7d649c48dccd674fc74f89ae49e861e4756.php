<?php $attributes = $attributes->exceptProps(['value', 'new' => false]); ?>
<?php foreach (array_filter((['value', 'new' => false]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $__defined_vars = get_defined_vars(); ?>
<?php foreach ($attributes as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
} ?>
<?php unset($__defined_vars); ?>

<label <?php echo e($attributes->merge(['class' => 'flex items-center gap-2 block font-medium text-sm text-gray-700'])); ?>>
    <span><?php echo e($value ?? $slot); ?></span>
    <?php if($new): ?>
    <span class="bg-indigo-500 text-white rounded px-2 my-1 text-xxs tracking-widest font-bold"><?php echo e(__('NEW')); ?></span>
    <?php endif; ?>
</label>
<?php /**PATH X:\xampp\htdocs\tm1\resources\views/vendor/jetstream/components/label.blade.php ENDPATH**/ ?>