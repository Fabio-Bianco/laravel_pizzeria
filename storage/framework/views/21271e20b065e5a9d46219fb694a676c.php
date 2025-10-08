<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

        <title><?php echo e(config('app.name', 'Laravel')); ?></title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
    </head>
    <body>
        <div class="min-vh-100 bg-light">
            <?php echo $__env->make('layouts.navigation', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
            <?php echo $__env->renderWhen(auth()->check() && request()->routeIs('admin.*'), 'layouts.sticky-header', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1])); ?>

            <!-- Page Heading -->
            <?php if(isset($header)): ?>
                <header class="bg-white border-bottom">
                    <div class="container py-3">
                            <?php echo e($header); ?>

                    </div>
                </header>
            <?php endif; ?>

            <!-- Page Content -->
            <?php ($hideFab = request()->routeIs('dashboard') || request()->routeIs('login') || request()->routeIs('register') || request()->routeIs('password.*') || request()->routeIs('verification.*')); ?>
            <main class="container my-4 <?php echo e($hideFab ? '' : 'has-fab'); ?>">
                <?php if (isset($component)) { $__componentOriginal635b39ef5be33bd3b6e46d3bb11dba21 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal635b39ef5be33bd3b6e46d3bb11dba21 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.command-palette','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('command-palette'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal635b39ef5be33bd3b6e46d3bb11dba21)): ?>
<?php $attributes = $__attributesOriginal635b39ef5be33bd3b6e46d3bb11dba21; ?>
<?php unset($__attributesOriginal635b39ef5be33bd3b6e46d3bb11dba21); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal635b39ef5be33bd3b6e46d3bb11dba21)): ?>
<?php $component = $__componentOriginal635b39ef5be33bd3b6e46d3bb11dba21; ?>
<?php unset($__componentOriginal635b39ef5be33bd3b6e46d3bb11dba21); ?>
<?php endif; ?>
                <?php if(isset($slot)): ?>
                    <?php echo e($slot); ?>

                <?php else: ?>
                    <?php echo $__env->yieldContent('content'); ?>
                <?php endif; ?>
                <?php if (! ($hideFab)): ?>
                    <?php if (isset($component)) { $__componentOriginal99804163784ece3bcee27febb36541a7 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal99804163784ece3bcee27febb36541a7 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.fab-nav','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('fab-nav'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal99804163784ece3bcee27febb36541a7)): ?>
<?php $attributes = $__attributesOriginal99804163784ece3bcee27febb36541a7; ?>
<?php unset($__attributesOriginal99804163784ece3bcee27febb36541a7); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal99804163784ece3bcee27febb36541a7)): ?>
<?php $component = $__componentOriginal99804163784ece3bcee27febb36541a7; ?>
<?php unset($__componentOriginal99804163784ece3bcee27febb36541a7); ?>
<?php endif; ?>
                <?php endif; ?>
            </main>
        </div>
    </body>
</html>
<?php /**PATH C:\Users\Utente\Desktop\project-work\pizzeria-backend\resources\views/layouts/app.blade.php ENDPATH**/ ?>