<!DOCTYPE html>
<html>
<head>
    <title>DEBUG PIZZE</title>
</head>
<body>
    <h1>DEBUG PIZZE - TEST MINIMO</h1>
    
    <?php if(isset($pizzas)): ?>
        <p>✅ Variabile pizzas ESISTE</p>
        <p>Tipo: <?php echo e(gettype($pizzas)); ?></p>
        
        <?php if(method_exists($pizzas, 'count')): ?>
            <p>Count: <?php echo e($pizzas->count()); ?></p>
            
            <?php if($pizzas->count() > 0): ?>
                <h2>PIZZE TROVATE:</h2>
                <?php $__currentLoopData = $pizzas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pizza): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div style="border: 1px solid #ccc; margin: 10px; padding: 10px;">
                        <h3><?php echo e($pizza->name ?? 'NOME NON TROVATO'); ?></h3>
                        <p>Prezzo: €<?php echo e($pizza->price ?? 'PREZZO NON TROVATO'); ?></p>
                        <p>ID: <?php echo e($pizza->id ?? 'ID NON TROVATO'); ?></p>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php else: ?>
                <p>❌ NESSUNA PIZZA NEL DATABASE</p>
            <?php endif; ?>
        <?php else: ?>
            <p>❌ PIZZAS NON HA METODO COUNT</p>
        <?php endif; ?>
    <?php else: ?>
        <p>❌ Variabile pizzas NON ESISTE</p>
    <?php endif; ?>
    
    <hr>
    <h2>DEBUG INFO:</h2>
    <p>PHP Version: <?php echo e(phpversion()); ?></p>
    <p>Laravel Version: <?php echo e(app()->version()); ?></p>
    
</body>
</html><?php /**PATH C:\Users\Utente\Desktop\project-work\pizzeria-backend\resources\views/admin/pizzas/minimal-debug.blade.php ENDPATH**/ ?>