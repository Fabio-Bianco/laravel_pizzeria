<?php if($paginator->hasPages()): ?>
    <div class="pagination-container d-flex justify-content-center">
        <nav role="navigation" aria-label="Pagination">
            <ul class="pagination mb-0">
                
                <?php if($paginator->onFirstPage()): ?>
                    <li class="page-item disabled"><span class="page-link">‹</span></li>
                <?php else: ?>
                    <li class="page-item"><a class="page-link" href="<?php echo e($paginator->previousPageUrl()); ?>" rel="prev">‹</a></li>
                <?php endif; ?>

                
                <?php $__currentLoopData = $elements; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $element): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    
                    <?php if(is_string($element)): ?>
                        <li class="page-item disabled"><span class="page-link"><?php echo e($element); ?></span></li>
                    <?php endif; ?>

                    
                    <?php if(is_array($element)): ?>
                        <?php $__currentLoopData = $element; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $page => $url): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php if($page == $paginator->currentPage()): ?>
                                <li class="page-item active"><span class="page-link"><?php echo e($page); ?></span></li>
                            <?php else: ?>
                                <li class="page-item"><a class="page-link" href="<?php echo e($url); ?>"><?php echo e($page); ?></a></li>
                            <?php endif; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php endif; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                
                <?php if($paginator->hasMorePages()): ?>
                    <li class="page-item"><a class="page-link" href="<?php echo e($paginator->nextPageUrl()); ?>" rel="next">›</a></li>
                <?php else: ?>
                    <li class="page-item disabled"><span class="page-link">›</span></li>
                <?php endif; ?>
            </ul>
        </nav>
    </div>
    
    <style>
    /* Nascondi qualsiasi testo di conteggio che potrebbe apparire */
    .pagination-container + p,
    .pagination-container ~ p,
    nav[aria-label="Pagination"] + p,
    nav[aria-label="Pagination"] ~ p {
        display: none !important;
    }
    </style>
<?php endif; ?><?php /**PATH C:\Users\Utente\Desktop\project-work\pizzeria-backend\resources\views/pagination/custom.blade.php ENDPATH**/ ?>