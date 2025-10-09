<?php $__env->startSection('title', 'Modifica: ' . $pizza->name); ?>

<?php $__env->startSection('header'); ?>
<div class="d-flex justify-content-between align-items-center">
    <div>
        <div class="d-flex align-items-center mb-2">
            <a href="<?php echo e(route('admin.pizzas.index')); ?>" class="btn btn-outline-secondary btn-sm me-3">
                <i class="fas fa-arrow-left me-1"></i>
                Indietro
            </a>
            <h1 class="page-title mb-0">
                <i class="fas fa-edit text-primary me-2"></i>
                Modifica: <?php echo e($pizza->name); ?>

            </h1>
        </div>
        <p class="page-subtitle">Aggiorna le informazioni della pizza</p>
    </div>
    <div>
        <span class="badge bg-light text-dark fs-6 px-3 py-2">
            <i class="fas fa-pizza-slice me-1"></i>
            Gestione Menu
        </span>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <?php echo $__env->make('partials.flash-modern', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    
    <div class="row justify-content-center">
        <div class="col-12">
            <form action="<?php echo e(route('admin.pizzas.update', $pizza)); ?>" method="POST" enctype="multipart/form-data" novalidate>
                <?php echo csrf_field(); ?> <?php echo method_field('PUT'); ?>

                
                <div class="row g-4 mb-4">
                    
                    <div class="col-12 col-lg-6">
                        <div class="card border-0 shadow-sm h-100">
                            <div class="card-header bg-white border-bottom">
                                <h5 class="card-title mb-0">
                                    <i class="fas fa-info-circle text-primary me-2"></i>
                                    Informazioni Base
                                </h5>
                            </div>
                            <div class="card-body">
                                <div class="row g-3">
                                    <div class="col-12">
                                        <label for="name" class="form-label fw-semibold">
                                            <i class="fas fa-pizza-slice me-1"></i>
                                            Nome Pizza <span class="text-danger">*</span>
                                        </label>
                                        <input id="name" name="name" type="text" 
                                               class="form-control <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                               value="<?php echo e(old('name', $pizza->name)); ?>" 
                                               required>
                                        <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </div>

                                    <div class="col-6">
                                        <label for="price" class="form-label fw-semibold">
                                            <i class="fas fa-euro-sign me-1"></i>
                                            Prezzo <span class="text-danger">*</span>
                                        </label>
                                        <div class="input-group">
                                            <span class="input-group-text">€</span>
                                            <input id="price" name="price" type="number" step="0.01" 
                                                   class="form-control <?php $__errorArgs = ['price'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                                   value="<?php echo e(old('price', $pizza->price)); ?>" 
                                                   required>
                                        </div>
                                        <?php $__errorArgs = ['price'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </div>

                                    <div class="col-6">
                                        <label for="category_id" class="form-label fw-semibold">
                                            <i class="fas fa-tags me-1"></i>
                                            Categoria
                                        </label>
                                        <select id="category_id" name="category_id" 
                                                class="form-select <?php $__errorArgs = ['category_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                                data-choices>
                                            <option value="">Seleziona...</option>
                                            <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($category->id); ?>" 
                                                        data-is-white="<?php echo e($category->is_white ? '1' : '0'); ?>" 
                                                        <?php if(old('category_id', $pizza->category_id) == $category->id): echo 'selected'; endif; ?>>
                                                    <?php echo e($category->name); ?>

                                                    <?php if($category->is_white): ?> (Bianca) <?php endif; ?>
                                                </option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                        <?php $__errorArgs = ['category_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </div>

                                    <?php if($pizza->image_path): ?>
                                    <div class="col-12">
                                        <label class="form-label fw-semibold">Immagine Attuale</label>
                                        <div class="mb-2">
                                            <img src="<?php echo e(Storage::url($pizza->image_path)); ?>" 
                                                 alt="<?php echo e($pizza->name); ?>" 
                                                 class="img-thumbnail" 
                                                 style="max-height: 120px;">
                                        </div>
                                    </div>
                                    <?php endif; ?>

                                    <div class="col-12">
                                        <label for="image" class="form-label fw-semibold">
                                            <i class="fas fa-image me-1"></i>
                                            <?php echo e($pizza->image_path ? 'Sostituisci Immagine' : 'Immagine'); ?>

                                        </label>
                                        <input id="image" name="image" type="file" 
                                               class="form-control <?php $__errorArgs = ['image'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                               accept=".jpg,.jpeg,.png,.webp">
                                        <?php $__errorArgs = ['image'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                        <div class="form-text">JPG, PNG, WebP. Max: 2MB</div>
                                    </div>

                                    <div class="col-12">
                    <label for="description" class="form-label fw-semibold">
                      <i class="fas fa-align-left me-1"></i>
                      Descrizione
                    </label>
                    <textarea id="description" name="description" rows="3"
                          class="form-control <?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                          placeholder="Descrizione della pizza..."><?php echo e(old('description', $pizza->description)); ?></textarea>
                    <?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    
                    <div class="col-12 col-lg-6">
                        <div class="card border-0 shadow-sm h-100">
                            <div class="card-header bg-white border-bottom">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h5 class="card-title mb-0">
                                        <i class="fas fa-seedling text-success me-2"></i>
                                        Ingredienti
                                    </h5>
                                    <button type="button" class="btn btn-outline-success btn-sm" 
                                            data-bs-toggle="modal" data-bs-target="#newIngredientModal">
                                        <i class="fas fa-plus me-1"></i>
                                        Nuovo
                                    </button>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <label for="ingredients" class="form-label fw-semibold">
                                        Seleziona ingredienti
                                    </label>
                                    <select id="ingredients" name="ingredients[]" multiple 
                                            class="form-select <?php $__errorArgs = ['ingredients'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                            data-choices 
                                            placeholder="Cerca ingredienti..." 
                                            data-store-url="<?php echo e(route('admin.ingredients.store')); ?>">
                                        <?php $__currentLoopData = $ingredients; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ingredient): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($ingredient->id); ?>" 
                                                    data-is-tomato="<?php echo e($ingredient->is_tomato ? '1' : '0'); ?>" 
                                                    <?php if(collect(old('ingredients', $pizza->ingredients->pluck('id')))->contains($ingredient->id)): echo 'selected'; endif; ?>>
                                                <?php echo e($ingredient->name); ?>

                                            </option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                    <?php $__errorArgs = ['ingredients'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback d-block"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    <div id="whiteHelp" class="alert alert-warning mt-2 d-none">
                                        <i class="fas fa-info-circle me-1"></i>
                                        <strong>Pizza Bianca:</strong> Il pomodoro non può essere utilizzato.
                                    </div>
                                </div>

                                
                <div class="mb-3">
                  <div class="form-check form-switch mb-2">
                    <input class="form-check-input" type="checkbox" role="switch" 
                         id="is_vegan" name="is_vegan" value="1"
                         <?php if(old('is_vegan', $pizza->is_vegan)): echo 'checked'; endif; ?>>
                    <label class="form-check-label fw-semibold" for="is_vegan">
                      <i class="fas fa-leaf text-success me-1"></i>
                      <span class="text-success">Vegano</span>
                    </label>
                  </div>
                  <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" role="switch" 
                         id="is_gluten_free" name="is_gluten_free" value="1"
                         <?php if(old('is_gluten_free', $pizza->is_gluten_free)): echo 'checked'; endif; ?>>
                    <label class="form-check-label fw-semibold text-dark" for="is_gluten_free">
                      <i class="fas fa-bread-slice me-1 text-dark"></i>
                      <span class="text-dark">Senza Glutine</span>
                    </label>
                  </div>
                  <small class="text-muted">Spunta se la pizza è senza glutine</small>
                </div>

                                
                                <div class="mb-3">
                                    <label class="form-label fw-semibold text-warning">
                                        <i class="fas fa-exclamation-triangle me-1"></i>
                                        Allergeni Rilevati
                                    </label>
                                    <div id="automatic-allergens" class="p-2 bg-light border rounded">
                                        <em class="text-muted small">
                                            Caricamento...
                                        </em>
                                    </div>
                                </div>

                                
                                <div>
                                    <label class="form-label fw-semibold">
                                        <i class="fas fa-hand-paper me-1 text-warning"></i>
                                        Allergeni Aggiuntivi
                                    </label>
                                    <div class="row g-1" id="manual-allergens-container">
                                        <?php $__currentLoopData = ($allergens ?? [])->take(8); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $allergen): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <div class="col-6">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" 
                                                           name="manual_allergens[]" 
                                                           value="<?php echo e($allergen->id); ?>" 
                                                           id="allergen_<?php echo e($allergen->id); ?>" 
                                                           <?php if(collect(old('manual_allergens', $pizza->manual_allergens ?? []))->contains($allergen->id)): echo 'checked'; endif; ?>>
                                                    <label class="form-check-label small" for="allergen_<?php echo e($allergen->id); ?>">
                                                        <?php echo e($allergen->name); ?>

                                                    </label>
                                                </div>
                                            </div>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </div>
                                    <?php $__errorArgs = ['manual_allergens'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="text-danger mt-1 small"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body py-3">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-eye me-2 text-info"></i>
                            <strong class="me-3">Anteprima allergeni per i clienti:</strong>
                            <div id="final-allergens-preview">
                                <em class="text-muted">Caricamento...</em>
                            </div>
                        </div>
                    </div>
                </div>

                
                <div class="card border-0 shadow-sm">
                    <div class="card-body py-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <small class="text-muted">
                                <i class="fas fa-info-circle me-1"></i>
                                I campi con <span class="text-danger">*</span> sono obbligatori
                            </small>
                            <div class="d-flex gap-2">
                                <a href="<?php echo e(route('admin.pizzas.index')); ?>" class="btn btn-outline-secondary">
                                    <i class="fas fa-times me-1"></i>
                                    Annulla
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save me-1"></i>
                                    Aggiorna Pizza
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div> 
                       class="form-control form-control-lg <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                       value="<?php echo e(old('name', $pizza->name)); ?>" 
                       required>
                <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
              </div>

              <div class="col-12 col-md-4">
                <label for="price" class="form-label fw-semibold">
                    <i class="fas fa-euro-sign me-1"></i>
                    Prezzo <span class="text-danger">*</span>
                </label>
                <div class="input-group">
                    <span class="input-group-text">€</span>
                    <input id="price" name="price" type="number" step="0.01" 
                           class="form-control form-control-lg <?php $__errorArgs = ['price'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                           value="<?php echo e(old('price', $pizza->price)); ?>" 
                           required>
                </div>
                <?php $__errorArgs = ['price'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
              </div>

              <div class="col-12">
                <label for="category_id" class="form-label fw-semibold">
                    <i class="fas fa-tags me-1"></i>
                    Categoria <span class="text-danger">*</span>
                </label>
                <select id="category_id" name="category_id" 
                        class="form-select <?php $__errorArgs = ['category_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                        data-choices required>
                  <option value="">-</option>
                  <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($category->id); ?>" data-is-white="<?php echo e($category->is_white ? '1' : '0'); ?>" <?php if(old('category_id', $pizza->category_id) == $category->id): echo 'selected'; endif; ?>><?php echo e($category->name); ?></option>
                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
                <?php $__errorArgs = ['category_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
              </div>

              <div class="col-12">
                <label for="notes" class="form-label">Note</label>
                <textarea id="notes" name="notes" rows="2" class="form-control <?php $__errorArgs = ['notes'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" placeholder="Aggiunte speciali, cottura, richiami, ecc."><?php echo e(old('notes', $pizza->notes)); ?></textarea>
                <?php $__errorArgs = ['notes'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
              </div>

              <div class="col-12 col-md-6">
                <div class="d-flex justify-content-between align-items-center mb-1">
                  <label for="ingredients" class="form-label mb-0">Ingredienti</label>
                  <button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#newIngredientModal">+ Nuovo ingrediente</button>
                </div>
                <select id="ingredients" name="ingredients[]" multiple class="form-select <?php $__errorArgs = ['ingredients'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" data-choices placeholder="Seleziona ingredienti..." data-store-url="<?php echo e(route('admin.ingredients.store')); ?>">
                  <?php $__currentLoopData = $ingredients; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ingredient): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($ingredient->id); ?>" data-is-tomato="<?php echo e($ingredient->is_tomato ? '1' : '0'); ?>" <?php if($pizza->ingredients->pluck('id')->contains($ingredient->id)): echo 'selected'; endif; ?>><?php echo e($ingredient->name); ?></option>
                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
                <?php $__errorArgs = ['ingredients'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback d-block"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                <div id="whiteHelp" class="form-text text-warning d-none">Il pomodoro è disabilitato per le pizze bianche.</div>
              </div>

              <div class="col-12 col-md-6">
                <label for="image" class="form-label">Immagine</label>
                <input id="image" name="image" type="file" class="form-control <?php $__errorArgs = ['image'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" accept=".jpg,.jpeg,.png,.webp">
                <?php $__errorArgs = ['image'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

                <?php if($pizza->image_path): ?>
                  <div class="mt-2">
                    <img src="<?php echo e(asset('storage/'.$pizza->image_path)); ?>" alt="<?php echo e($pizza->name); ?>" class="rounded" style="width:120px;height:120px;object-fit:cover;">
                  </div>
                <?php endif; ?>
              </div>

              
              <div class="col-12">
                <div class="card border-info">
                  <div class="card-header bg-info-subtle">
                    <h6 class="mb-0"><i class="fas fa-exclamation-triangle me-1"></i> Allergeni</h6>
                  </div>
                  <div class="card-body">
                    
                    <div class="mb-3">
                      <label class="form-label fw-bold">Allergeni automatici (da ingredienti)</label>
                      <div id="automatic-allergens" class="border rounded p-2 bg-light">
                        
                      </div>
                    </div>

                    
                    <div class="mb-3">
                      <label for="manual_allergens" class="form-label fw-bold">Allergeni aggiuntivi <small class="text-muted">(opzionale)</small></label>
                      <div class="row" id="manual-allergens-container">
                        <?php $__currentLoopData = $allergens; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $allergen): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                          <div class="col-md-4 col-sm-6">
                            <div class="form-check">
                              <input class="form-check-input" type="checkbox" name="manual_allergens[]" value="<?php echo e($allergen->id); ?>" id="allergen_<?php echo e($allergen->id); ?>" 
                                <?php if(collect(old('manual_allergens', $pizza->manual_allergens ?? []))->contains($allergen->id)): echo 'checked'; endif; ?>>
                              <label class="form-check-label" for="allergen_<?php echo e($allergen->id); ?>"><?php echo e($allergen->name); ?></label>
                            </div>
                          </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                      </div>
                      <?php $__errorArgs = ['manual_allergens'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="text-danger mt-1"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    
                    <div class="alert alert-info mb-0">
                      <strong>Allergeni finali che vedranno i clienti:</strong>
                      <div id="final-allergens-preview" class="mt-1">
                        <em class="text-muted">Caricamento...</em>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <div class="d-flex justify-content-end gap-2 mt-4">
              <a href="<?php echo e(route('admin.pizzas.index')); ?>" class="btn btn-outline-secondary">Annulla</a>
              <button type="submit" class="btn btn-primary">Salva</button>
            </div>
          </form>
        </div>
      </div>

      
      <div class="modal fade" id="newIngredientModal" tabindex="-1" aria-labelledby="newIngredientModalLabel" aria-hidden="true">
        <div class="modal-dialog"><div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="newIngredientModalLabel">Nuovo ingrediente</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Chiudi"></button>
          </div>
          <div class="modal-body">
            <div class="mb-3">
              <label for="ni_name" class="form-label">Nome</label>
              <input type="text" id="ni_name" class="form-control" />
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Annulla</button>
            <button type="button" id="ni_save" class="btn btn-primary">Crea</button>
          </div>
        </div></div>
      </div>
    </div>
  </div>

  
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const ingredientsSelect = document.getElementById('ingredients');
      const automaticAllergensDiv = document.getElementById('automatic-allergens');
      const manualAllergensContainer = document.getElementById('manual-allergens-container');
      const finalAllergensPreview = document.getElementById('final-allergens-preview');
      
      let automaticAllergens = [];
      
      function updateAutomaticAllergens() {
        const selectedIngredients = Array.from(ingredientsSelect.selectedOptions).map(option => option.value);
        
        if (selectedIngredients.length === 0) {
          automaticAllergens = [];
          automaticAllergensDiv.innerHTML = '<em class="text-muted">Seleziona ingredienti per vedere gli allergeni automatici</em>';
          updateFinalPreview();
          return;
        }
        
        fetch('<?php echo e(route("admin.ajax.ingredients-allergens")); ?>?' + new URLSearchParams({
          ingredient_ids: selectedIngredients
        }), {
          headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Accept': 'application/json',
            'Content-Type': 'application/json'
          }
        })
        .then(response => response.json())
        .then(data => {
          automaticAllergens = data.allergens || [];
          
          if (automaticAllergens.length === 0) {
            automaticAllergensDiv.innerHTML = '<em class="text-muted">Nessun allergene automatico</em>';
          } else {
            automaticAllergensDiv.innerHTML = automaticAllergens.map(allergen => 
              `<span class="badge bg-warning text-dark me-1">${allergen.name}</span>`
            ).join('');
          }
          
          updateFinalPreview();
        });
      }
      
      function updateFinalPreview() {
        const manualCheckboxes = manualAllergensContainer.querySelectorAll('input[type="checkbox"]:checked');
        const manualAllergens = Array.from(manualCheckboxes).map(cb => ({
          id: cb.value,
          name: cb.nextElementSibling.textContent
        }));
        
        const allAllergens = [...automaticAllergens];
        manualAllergens.forEach(manual => {
          if (!allAllergens.find(auto => auto.id == manual.id)) {
            allAllergens.push(manual);
          }
        });
        
        if (allAllergens.length === 0) {
          finalAllergensPreview.innerHTML = '<em class="text-muted">Nessun allergene</em>';
        } else {
          finalAllergensPreview.innerHTML = allAllergens.map(allergen => 
            `<span class="badge bg-danger me-1">${allergen.name}</span>`
          ).join('');
        }
      }
      
      ingredientsSelect.addEventListener('change', updateAutomaticAllergens);
      manualAllergensContainer.addEventListener('change', function(e) {
        if (e.target.type === 'checkbox') updateFinalPreview();
      });
      
      // Inizializzazione con dati esistenti
      updateAutomaticAllergens();
      
      // Gestione modal nuovo ingrediente
      const newIngredientModal = document.getElementById('newIngredientModal');
      const saveButton = document.getElementById('ni_save');
      const nameInput = document.getElementById('ni_name');
      
      if (saveButton && nameInput) {
        saveButton.addEventListener('click', function() {
          const name = nameInput.value.trim();
          if (!name) {
            alert('Inserisci il nome dell\'ingrediente');
            return;
          }
          
          const storeUrl = ingredientsSelect.dataset.storeUrl;
          if (!storeUrl) {
            alert('URL di creazione non configurato');
            return;
          }
          
          fetch(storeUrl, {
            method: 'POST',
            headers: {
              'Content-Type': 'application/json',
              'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
            },
            body: JSON.stringify({ name: name })
          })
          .then(response => response.json())
          .then(data => {
            if (data.success) {
              // Aggiungi la nuova opzione al select
              const option = document.createElement('option');
              option.value = data.ingredient.id;
              option.textContent = data.ingredient.name;
              option.selected = true;
              ingredientsSelect.appendChild(option);
              
              // Aggiorna Choices.js se presente
              if (ingredientsSelect._choices) {
                ingredientsSelect._choices.setChoiceByValue(data.ingredient.id.toString());
              }
              
              // Chiudi modal e reset
              bootstrap.Modal.getInstance(newIngredientModal).hide();
              nameInput.value = '';
              
              // Aggiorna allergeni
              updateAutomaticAllergens();
            } else {
              alert('Errore nella creazione: ' + (data.message || 'Errore sconosciuto'));
            }
          })
          .catch(error => {
            console.error('Errore:', error);
            alert('Errore di rete');
          });
        });
      }
    });
  </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app-modern', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Utente\Desktop\project-work\pizzeria-backend\resources\views/admin/pizzas/edit.blade.php ENDPATH**/ ?>