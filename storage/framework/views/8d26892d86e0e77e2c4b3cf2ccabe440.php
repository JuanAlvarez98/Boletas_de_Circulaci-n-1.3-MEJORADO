<?php if($paginator->hasPages()): ?>
    <nav role="navigation" aria-label="<?php echo e(__('Pagination Navigation')); ?>" style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 14px; width: 100%; margin-top: 20px; font-size: 13.5px;">
        <div>
            <p style="margin: 0; color: #64748b; font-size: 13px;">
                Mostrando
                <?php if($paginator->firstItem()): ?>
                    <span style="font-weight: 700; color: #0f172a;"><?php echo e($paginator->firstItem()); ?></span>
                    a
                    <span style="font-weight: 700; color: #0f172a;"><?php echo e($paginator->lastItem()); ?></span>
                <?php else: ?>
                    <?php echo e($paginator->count()); ?>

                <?php endif; ?>
                de
                <span style="font-weight: 700; color: #0f172a;"><?php echo e($paginator->total()); ?></span>
                resultados
            </p>
        </div>

        <div style="display: inline-flex; align-items: center; background: #ffffff; border: 1.5px solid #cbd5e1; border-radius: 9px; overflow: hidden; box-shadow: 0 1px 3px rgba(0,0,0,0.05);">
            
            <?php if($paginator->onFirstPage()): ?>
                <span style="display: inline-flex; align-items: center; justify-content: center; width: 36px; height: 36px; color: #cbd5e1; cursor: not-allowed; background: #f8fafc; border-right: 1px solid #e2e8f0;" aria-disabled="true">
                    <svg width="16" height="16" style="width: 16px; height: 16px; display: inline-block;" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                    </svg>
                </span>
            <?php else: ?>
                <a href="<?php echo e($paginator->previousPageUrl()); ?>" rel="prev" style="display: inline-flex; align-items: center; justify-content: center; width: 36px; height: 36px; color: #334155; text-decoration: none; border-right: 1px solid #e2e8f0; transition: background 0.2s;" onmouseover="this.style.background='#f1f5f9'" onmouseout="this.style.background='#ffffff'">
                    <svg width="16" height="16" style="width: 16px; height: 16px; display: inline-block;" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                    </svg>
                </a>
            <?php endif; ?>

            
            <?php $__currentLoopData = $elements; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $element): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php if(is_string($element)): ?>
                    <span style="display: inline-flex; align-items: center; justify-content: center; padding: 0 12px; height: 36px; color: #94a3b8; font-weight: 600; border-right: 1px solid #e2e8f0;"><?php echo e($element); ?></span>
                <?php endif; ?>

                <?php if(is_array($element)): ?>
                    <?php $__currentLoopData = $element; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $page => $url): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php if($page == $paginator->currentPage()): ?>
                            <span style="display: inline-flex; align-items: center; justify-content: center; min-width: 36px; height: 36px; padding: 0 10px; font-weight: 700; color: #ffffff; background: #2563eb; border-right: 1px solid #2563eb;" aria-current="page"><?php echo e($page); ?></span>
                        <?php else: ?>
                            <a href="<?php echo e($url); ?>" style="display: inline-flex; align-items: center; justify-content: center; min-width: 36px; height: 36px; padding: 0 10px; font-weight: 600; color: #334155; text-decoration: none; border-right: 1px solid #e2e8f0; transition: background 0.2s;" onmouseover="this.style.background='#f1f5f9'" onmouseout="this.style.background='#ffffff'"><?php echo e($page); ?></a>
                        <?php endif; ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php endif; ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

            
            <?php if($paginator->hasMorePages()): ?>
                <a href="<?php echo e($paginator->nextPageUrl()); ?>" rel="next" style="display: inline-flex; align-items: center; justify-content: center; width: 36px; height: 36px; color: #334155; text-decoration: none; transition: background 0.2s;" onmouseover="this.style.background='#f1f5f9'" onmouseout="this.style.background='#ffffff'">
                    <svg width="16" height="16" style="width: 16px; height: 16px; display: inline-block;" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                    </svg>
                </a>
            <?php else: ?>
                <span style="display: inline-flex; align-items: center; justify-content: center; width: 36px; height: 36px; color: #cbd5e1; cursor: not-allowed; background: #f8fafc;" aria-disabled="true">
                    <svg width="16" height="16" style="width: 16px; height: 16px; display: inline-block;" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                    </svg>
                </span>
            <?php endif; ?>
        </div>
    </nav>
<?php endif; ?>
<?php /**PATH C:\Users\JUANALEJANDROALVAREZ\PROYECTOS\Laravel\Boletas_de_Circulación 1.3 MEJORADO\resources\views/vendor/pagination/tailwind.blade.php ENDPATH**/ ?>