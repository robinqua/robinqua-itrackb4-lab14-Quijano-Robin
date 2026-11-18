<nav class="navbar navbar-expand-lg bg-dark" data-bs-theme="dark" aria-label="Main navigation">
    <div class="container-fluid">
        <a class="navbar-brand" href="<?php echo e(route('home')); ?>">Quijano Library</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavigation"
                aria-controls="mainNavigation" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="mainNavigation">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a href="<?php echo e(route('home')); ?>"
                       class="nav-link <?php echo e(request()->routeIs('home') ? 'active' : ''); ?>"
                       <?php if(request()->routeIs('home')): ?> aria-current="page" <?php endif; ?>>
                        Home
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?php echo e(route('books.index')); ?>"
                       class="nav-link <?php echo e(request()->routeIs('books.*') ? 'active' : ''); ?>"
                       <?php if(request()->routeIs('books.*')): ?> aria-current="page" <?php endif; ?>>
                        Books
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?php echo e(route('books.featured')); ?>"
                       class="nav-link <?php echo e(request()->routeIs('books.featured') ? 'active' : ''); ?>"
                       <?php if(request()->routeIs('books.featured')): ?> aria-current="page" <?php endif; ?>>
                        Featured Book
                    </a>
                </li>
            </ul>
            <ul class="navbar-nav ms-auto">
                <?php if(auth()->guard()->guest()): ?>
                    <li class="nav-item">
                        <a href="<?php echo e(route('login')); ?>" class="nav-link">Log in</a>
                    </li>
                    <li class="nav-item">
                        <a href="<?php echo e(route('register')); ?>" class="nav-link">Register</a>
                    </li>
                <?php endif; ?>

                <?php if(auth()->guard()->check()): ?>
                    <li class="nav-item">
                        <span class="navbar-text me-3"><?php echo e(Auth::user()->name); ?></span>
                    </li>
                    <li class="nav-item">
                        <form method="POST" action="<?php echo e(route('logout')); ?>">
                            <?php echo csrf_field(); ?>
                            <button type="submit" class="nav-link">Log out</button>
                        </form>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>
<?php /**PATH C:\itrackb4-la5-Quijano-Robin-main\resources\views/partials/_nav.blade.php ENDPATH**/ ?>