<?php if(session('status')): ?>
  <div class="alert alert-success alert-dismissible fade show" role="alert">
    <?php echo e(session('status')); ?>

    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
<?php endif; ?>

<?php if($errors->any()): ?>
  <div class="alert alert-danger alert-dismissible fade show" role="alert">
    <strong>Correggi gli errori:</strong>
    <ul class="mb-0 mt-1">
      <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $e): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <li><?php echo e($e); ?></li>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </ul>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
<?php endif; ?>
<?php /**PATH C:\Users\Utente\Desktop\project-work\pizzeria-backend\resources\views/partials/flash.blade.php ENDPATH**/ ?>