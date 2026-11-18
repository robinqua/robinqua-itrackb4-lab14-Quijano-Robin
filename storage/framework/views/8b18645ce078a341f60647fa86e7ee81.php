

<?php $__env->startSection('title', 'Discover Books'); ?>

<?php $__env->startSection('content'); ?>
    <section class="py-5">
        <div class="card shadow-sm border-0 mx-auto text-center p-4 p-md-5" style="max-width: 42rem;">
            <div class="d-flex align-items-center justify-content-center gap-3 mb-4 text-start">
                <img src="<?php echo e(asset('img/robin-quijano.jpg')); ?>" alt="Profile picture of Robin Quijano"
                     class="rounded-circle border shadow-sm flex-shrink-0"
                     width="96" height="96"
                     style="object-fit: cover; object-position: center;">
                <div>
                    <h2 class="h4 mb-1">Robin Quijano</h2>
                    <p class="text-muted mb-0">BSInfoTech 4A</p>
                </div>
            </div>

            <h3>A place to discover your next favorite book</h3>
            <p>Welcome to my personal library. Browse the collection, search by title or author, and find something new to read.</p>
            <div>
                <a href="<?php echo e(route('books.index')); ?>" class="btn btn-primary">Browse the book collection</a>
            </div>

            <div class="d-flex justify-content-center flex-wrap gap-4 mt-4">
                <p class="mb-0"><strong>Books in the collection:</strong> <?php echo e($bookCount); ?></p>
                <p class="mb-0"><strong>Genres represented by books:</strong> <?php echo e($genreCount); ?></p>
            </div>
        </div>
    </section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\itrackb4-la5-Quijano-Robin-main\resources\views/home.blade.php ENDPATH**/ ?>