

<?php $__env->startSection('title', 'My Book List'); ?>

<?php $__env->startSection('content'); ?>
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
        <div>
            <h1 class="mb-1">My Book List</h1>
            <p class="mb-0"><strong>Books in collection:</strong> <span data-testid="book-count"><?php echo e($bookCount); ?></span></p>
        </div>
        <a href="<?php echo e(route('books.create')); ?>" class="btn btn-success">Add a Book</a>
    </div>

    <form method="GET" action="<?php echo e(route('books.index')); ?>" class="row g-2 align-items-end mb-4">
        <div class="col-md-4">
            <label for="search" class="form-label">Search books</label>
            <input id="search" name="search" type="search" value="<?php echo e($search); ?>" class="form-control"
                   placeholder="Title, author, or ISBN">
        </div>
        <div class="col-md-2">
            <label for="author" class="form-label">Author</label>
            <select id="author" name="author" class="form-select">
                <option value="">All authors</option>
                <?php $__currentLoopData = $authorOptions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $authorOption): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($authorOption); ?>" <?php if((string) $author === (string) $authorOption): echo 'selected'; endif; ?>>
                        <?php echo e($authorOption); ?>

                    </option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>
        <div class="col-md-2">
            <label for="pages" class="form-label">Pages</label>
            <select id="pages" name="pages" class="form-select">
                <option value="">Any length</option>
                <?php $__currentLoopData = $pageOptions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pageOption): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($pageOption); ?>" <?php if((string) $pages === (string) $pageOption): echo 'selected'; endif; ?>>
                        <?php echo e($pageOption); ?> pages
                    </option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>
        <div class="col-md-2">
            <label for="genre" class="form-label">Genre</label>
            <select id="genre" name="genre" class="form-select">
                <option value="">All genres</option>
                <?php $__currentLoopData = $genreOptions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $genreOption): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($genreOption); ?>" <?php if($genre === $genreOption): echo 'selected'; endif; ?>><?php echo e($genreOption); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>
        <div class="col-md-2">
            <label for="sort" class="form-label">Sort by</label>
            <select id="sort" name="sort" class="form-select">
                <?php $__currentLoopData = $sortOptions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sortKey => $sortLabel): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($sortKey); ?>" <?php if($sort === $sortKey): echo 'selected'; endif; ?>><?php echo e($sortLabel); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>
        <input type="hidden" name="direction" value="<?php echo e($direction); ?>">
        <div class="col-md-1 d-grid">
            <button type="submit" class="btn btn-primary">Go</button>
        </div>
        <div class="col-12">
            <a href="<?php echo e(route('books.index')); ?>" class="btn btn-link px-0">Clear search and filters</a>
        </div>
    </form>

    <p class="text-muted">
        Showing <?php echo e($books->firstItem() ?? 0); ?>–<?php echo e($books->lastItem() ?? 0); ?>

        of <?php echo e($books->total()); ?> matching books.
    </p>

    <div class="table-responsive">
        <table class="table table-striped table-bordered align-middle">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">ID</th>
                    <th scope="col">ISBN</th>
                    <th scope="col">Title</th>
                    <th scope="col">Author</th>
                    <th scope="col">Genre</th>
                    <th scope="col">Pages</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $books; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $book): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td><?php echo e($books->firstItem() + $loop->index); ?></td>
                        <td><?php echo e($book->id); ?></td>
                        <td><a href="<?php echo e(route('books.show', $book)); ?>"><?php echo e($book->isbn); ?></a></td>
                        <td><?php echo e($book->title); ?></td>
                        <td><?php echo e($book->author); ?></td>
                        <td><?php echo e($book->genre ?? 'Uncategorized'); ?></td>
                        <td>
                            <?php if($book->pages >= 300): ?>
                                <strong><?php echo e($book->pages); ?> (Long Read)</strong>
                            <?php else: ?>
                                <?php echo e($book->pages); ?>

                            <?php endif; ?>
                        </td>
                        <td>
                            <div class="d-flex flex-wrap gap-2">
                                <a href="<?php echo e(route('books.edit', $book)); ?>" class="btn btn-sm btn-warning">Edit</a>
                                <form action="<?php echo e(route('books.destroy', $book)); ?>" method="POST"
                                      onsubmit="return confirm('Delete this record?')">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('DELETE'); ?>
                                    <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="8">No books match this search and these filters.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <?php echo e($books->appends(request()->except('page'))->links('pagination::bootstrap-5')); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\itrackb4-la5-Quijano-Robin-main\resources\views/books/index.blade.php ENDPATH**/ ?>