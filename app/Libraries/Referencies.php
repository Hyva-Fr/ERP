<?php

use Illuminate\Support\Facades\Schema;
use Carbon\Carbon;
use App\Models\Ip;
use App\Models\Category;

if (!function_exists('setTrans')) {

    function setTrans(): array
    {
        return [
            'agencies' => 'agency',
            'states' => 'state',
            'countries' => 'country',
            'geographic-zones' => 'geographic_zone',
            'forms' => 'form',
            'categories' => 'category',
            'roles' => 'role',
            'users' => 'user',
            'completed-forms' => 'completed_form',
            'missions' => 'mission',
            'societies' => 'society',
            'emails' => 'email',
            'processes' => 'process',
            'subjects' => 'subject',
            'notifications' => 'notification',
            'conditions' => 'condition'
        ];
    }
}

if (!function_exists('getIcon')) {

    function getIcon($routeName): string
    {
        $refs = [
            'agencies' => 'fa-industry',
            'states' => 'fa-industry',
            'countries' => 'fa-industry',
            'geographic-zones' => 'fa-industry',
            'forms' => 'fa-list-check',
            'categories' => 'fa-list-check',
            'roles' => 'fa-shield-halved',
            'users' => 'fa-users',
            'completed-forms' => 'fa-list-check',
            'missions' => 'fa-barcode',
            'societies' => 'fa-tags',
            'emails' => 'fa-shield-halved',
            'processes' => 'fa-shield-halved',
            'subjects' => 'fa-shield-halved',
            'notifications' => 'fa-shield-halved',
            'conditions' => 'fa-shield-halved'
        ];

        return isset($refs[$routeName])
            ? '<i class="fa-solid ' . $refs[$routeName] . ' fa-fw"></i>'
            : '';
    }
}

if (!function_exists('svg')) {

    function svg($file, $class, $array = false, $container = false): string
    {
        $js = '';

        if ($array !== false) {

            foreach ($array as $foo) {

                $js .= ' ' . $foo[0] . '="' . $foo[1] . '"';
            }
        }

        $path = dirname(__DIR__, 2) . '/storage/app/svg/' . $file . '.svg';

        if (file_exists($path)) {

            ob_start();
            $inner = str_replace('<svg ', '<svg class="' . $class . '" ', file_get_contents($path));

            if (str_contains($inner, '<title>') && str_contains($inner, '</title>')) {

                $final1 = substr($inner, 0, strpos($inner, '<title>'));
                $final2 = substr($inner, strpos($inner, '</title>'), strlen($inner));
                $final = $final1 . $final2;

            } else {

                $final = $inner;
            }

            echo ($container === true) ? '<div class="' . explode(' ', $class)[0] . '"' . $js . '>' . $final . '</div>' : $final;
            return ob_get_clean();
        }
    }
}

if (!function_exists('createUserInitials')) {

    function createUserInitials($firstname, $lastname): string
    {
        $first = strtoupper($firstname[0]);
        $last = strtoupper($lastname[0]);
        return $first . $last;
    }
}

if (!function_exists('setSelectedParent')) {

    function setSelectedParent($routes, $excepts = []): string
    {
        $current = \Request::route()->getName();
        foreach ($routes as $route) {
            if (str_starts_with($current, $route) && !in_array($current, $excepts, true)) {
                return 'selected';
            }
        }
        return '';
    }
}

if (!function_exists('setColumns')) {

    function setColumns($keys, $excepts): array
    {
        $indexes = [];
        foreach ($keys as $key) {
            if (!in_array($key, $excepts, true)) {
                $indexes[] = str_replace('_id', '', $key);
            }
        }
        return $indexes;
    }
}

if (!function_exists('getDataTypes')) {

    /**
     * @throws JsonException
     */
    function getDataTypes(): array
    {
        $json = file_get_contents(__DIR__ . '/DataTypes.json');
        return json_decode($json, true, 512, JSON_THROW_ON_ERROR);
    }
}

if (!function_exists('getFormsTypes')) {

    /**
     * @throws JsonException
     */
    function getFormsTypes(): array
    {
        $json = file_get_contents(__DIR__ . '/FormsTypes.json');
        return json_decode($json, true, 512, JSON_THROW_ON_ERROR);
    }
}

if (!function_exists('setAvatar')) {

    /**
     * @throws JsonException
     */
    function setAvatar($value): string
    {
        $json = file_get_contents(__DIR__ . '/Base64.json');
        $json = json_decode($json, true, 512, JSON_THROW_ON_ERROR);
        return ($value === '' || $value === null) ? $json['default-avatar'] : $value;
    }
}

if (!function_exists('setDocument')) {

    /**
     * @throws JsonException
     */
    function setDocument($value): string
    {
        $json = file_get_contents(__DIR__ . '/Base64.json');
        $json = json_decode($json, true, 512, JSON_THROW_ON_ERROR);
        return ($value === '' || is_null($value)) ? $json['default-document'] : $value;
    }
}

if (!function_exists('setRowType')) {

    function setRowType($value, $column, $table): ?string
    {
        $refs = getDataTypes();
        $type = Schema::getColumnType($table, $column);

        if ($column === 'avatar') {

            $value = setAvatar($value);

            return '<p class="crud-image-container"><span class="crud-image" style="background-image: url(\'' . $value . '\');" alt="' . $column . '"></span></p>';

        } else if ($column === 'email') {

            return '<a class="crud-email" href="mailto:' . $value . '"><i class="fa-solid fa-at fa-lg fa-fw"></i>' . $value . '</a>';

        } else {

            if (in_array($type, $refs['numeric'], true)) {

                return '<span class="blue">' . $value . '</span>';

            } else if (in_array($type, $refs['bool'], true)) {

                return ($value)
                    ? '<i class="fa-solid fa-circle-check fa-lg fa-fw green"></i>'
                    : '<i class="fa-solid fa-circle-xmark fa-lg fa-fw red"></i>';

            } else if (in_array($type, $refs['dates'], true)) {

                if ($type === 'datetime' || $type === 'timestamp') {

                    return '<span class="crud-cal"><i class="fa-solid fa-calendar-days fa-lg fa-fw"></i>' . Carbon::parse($value)->isoFormat('lll') . '<i class="fa-solid fa-clock fa-lg fa-fw"></i></span>';

                } else if ($type === 'date') {

                    return '<span class="crud-cal"><i class="fa-solid fa-calendar-days fa-lg fa-fw"></i>' . Carbon::parse($value)->isoFormat('ll') . '</span>';

                } else if ($type === 'time') {

                    return '<span class="crud-cal"><i class="fa-solid fa-clock fa-lg fa-fw"></i>' . date("H:i") . '</span>';
                }
            }
        }
        return $value;
    }
}

if (!function_exists('isFK')) {

    function isFK(string $table, string $column): bool
    {
        $fkColumns = Schema::getConnection()
            ->getDoctrineSchemaManager()
            ->getDoctrineSchemaManager()
            ->listTableForeignKeys($table);

        return collect($fkColumns)->map(function ($fkColumn) {
            return $fkColumn->getColumns();
        })->flatten()->contains($column);
    }
}

if (!function_exists('commonRoute')) {

    function commonRoute($single = false): string
    {
        $cut = str_replace('.index', '', \Request::route()->getName());
        if ($single === false) {
            return $cut;
        }
        $trans = setTrans();

        return $trans[$cut] ?? $cut;
    }
}

if (!function_exists('getRouteFullName')) {

    function getRouteFullName($routeName): string
    {
        $split = explode('.', $routeName);
        $name = $split[0];
        return (isset($split[1]))
            ? ucfirst($split[1]) . ' ' . str_replace('_', ' ', $name)
            : ucfirst(str_replace('_', ' ', $name));
    }
}

if (!function_exists('getSingleFullName')) {

    function getSingleFullName($routeName): string
    {
        $split = explode('.', $routeName);
        $name = $split[0];
        $trans = setTrans();
        return (isset($split[1]))
            ? ucfirst($split[1]) . ' ' . str_replace('_', ' ', $trans[$name])
            : ucfirst(str_replace('_', ' ', $trans[$name]));
    }
}

if (!function_exists('brutalForceGuard')) {

    /**
     * @throws JsonException
     */
    function brutalForceGuard($data): bool
    {
        $max = $data['attempts'];
        $location = $data['location'];
        $ip = Ip::select('attempts', 'is_ban')->where('address', $location->ip)->first();
        if (null === $ip) {

            Ip::create([
                'address' => $location->ip,
                'data' => json_encode($location, JSON_THROW_ON_ERROR)
            ]);

        } else {

            if ($ip->is_ban === 1) {

                return true;

            } else {

                if ($ip->attempts >= $max - 1) {

                    $ip->attempts++;
                    Ip::where('address', $location->ip)->update([
                        'attempts' => $ip->attempts++,
                        'is_ban' => 1
                    ]);
                    return true;

                } else {

                    $ip->attempts++;
                    Ip::where('address', $location->ip)->update([
                        'attempts' => $ip->attempts,
                        'is_ban' => 0
                    ]);
                }
            }
        }

        return false;
    }
}

if (!function_exists('breadCrumbs')) {

    function breadCrumbs(): string
    {
        $path = str_replace(config('app.url'), '', url()->current());
        $breadCrumbs = [];
        $explode = explode('/', $path);
        $recompose = config('app.url');
        $cnt = 0;
        foreach ($explode as $crumb) {
            if ($cnt < count($explode) - 1) {
                if ($crumb === '') {
                    $breadCrumbs[] = '<i class="fa-solid fa-house fa-lg fa-fw"></i><a href="' . route('dashboard') . '">' . __('Dashboard') . '</a>';
                } else {
                    $recompose .= '/' . $crumb;
                    $breadCrumbs[] = '<a href="' . $recompose . '">' . __($crumb) . '</a>';
                }
            } else if ($crumb !== '') {
                $breadCrumbs[] = '<span>' . __($crumb) . '</span>';
            }
            $cnt++;
        }

        return (!empty($breadCrumbs))
            ? '<div id="bread-crumbs">' . implode('<i class="fa-solid fa-arrow-right fa-lg fa-fw"></i>', $breadCrumbs) . '</div>'
            : '';
    }
}

if (!function_exists('shortCodesList')) {

    function shortCodesList($shortcodes): string
    {
        ob_start(); ?>
        <div class="shortcodes-container">
            <span><?= __('Short codes') ?></span>
            <?php if(empty($shortcodes)): ?>
                <p><?= __('No short code available for this template.') ?></p>
            <?php else: ?>
                <ul>

                </ul>
            <?php endif; ?>
        </div>
        <?php return ob_get_clean();
    }
}

if (!function_exists('setForm')) {

    /**
     * @throws JsonException
     */
    function setForm(): string {

        $json = getFormsTypes();
        ob_start(); ?>
            <div class="form-builder">
                <div id="form-header-choice" class="creator-formats">
                    <p><?= __('Choose header format') ?></p>
                    <div class="crud-radios form-control">
                        <?php $headerCnt = 0; $selectedHeader = null; ?>
                        <?php foreach ($json['headers'] as $header): ?>
                            <?php if ($headerCnt === 0): $selectedHeader = $header; endif; ?>
                        <label>
                            <input class="with-font" value="<?= $header ?>" type="radio" <?php if ($headerCnt === 0): ?> checked <?php endif; ?>name="header-format">
                            <span>
                                <?= ucfirst(__($header)) ?>
                            </span>
                        </label>
                            <?php $headerCnt++; ?>
                        <?php endforeach; ?>
                    </div>
                    <div class="split-preview" id="header-pic-preview" style='background-image: url("/storage/media/templates/form/header/<?= $selectedHeader ?>.jpg")'></div>
                </div>
                <div id="form-content-choice" class="creator-formats">
                    <p><?= __('Choose content format') ?></p>
                    <div class="crud-radios form-control">
                        <?php $contentCnt = 0; $selectedContent = null; ?>
                        <?php foreach ($json['content'] as $content): ?>
                            <?php if ($contentCnt === 0): $selectedContent = $content; endif; ?>
                            <label>
                                <input class="with-font" value="<?= $content ?>" type="radio" <?php if ($contentCnt === 0): ?> checked <?php endif; ?>name="content-format">
                                <span>
                                    <?= ucfirst(__($content)) ?>
                                </span>
                            </label>
                            <?php $contentCnt++; ?>
                        <?php endforeach; ?>
                    </div>
                    <div class="split-preview" id="content-pic-preview" style='background-image: url("/storage/media/templates/form/content/<?= $selectedContent ?>.jpg")'></div>
                </div>
                <div id="form-footer-choice" class="creator-formats">
                    <p><?= __('Choose footer format') ?></p>
                    <div class="crud-radios form-control">
                        <?php $footerCnt = 0; $selectedFooter = null; ?>
                        <?php foreach ($json['footers'] as $footer): ?>
                            <?php if ($footerCnt === 0): $selectedFooter = $footer; endif; ?>
                            <label>
                                <input class="with-font" value="<?= $footer ?>" type="radio" <?php if ($footerCnt === 0): ?> checked <?php endif; ?>name="footer-format">
                                <span>
                                    <?= ucfirst(__($footer)) ?>
                                </span>
                            </label>
                            <?php $footerCnt++; ?>
                        <?php endforeach; ?>
                    </div>
                    <div class="split-preview" id="footer-pic-preview" style='background-image: url("/storage/media/templates/form/footer/<?= $selectedFooter ?>.jpg")'></div>
                </div>
                <div id="refs-editor" class="sub-form-editor xLarge-6 large-6 medium-12 small-12 xSmall-12" data-message="<?= __('You must open form with a Start section.') ?>" data-endform="<?= __('You must close form with a End section.') ?>" data-delete="<?= __('You can\'t delete a Start block before delete the next elements') ?>">
                    <div class="refs-block special" id="start-section">
                        <div>
                            <p class="block-title"><?= __('Start section') ?></p>
                            <small><?= __('Constructor type') ?></small>
                        </div>
                        <i class="fa-solid fa-circle-plus fa-lg fa-fw new-block" data-json="start" data-title="<?= __('Start section') ?>" data-small="<?= __('Constructor type') ?>" data-message="<?= __('You can\'t Start a section before closing the previous one with a End Section') ?>" data-info='<?= json_encode(["type" => "constructor", "label" => "", "options" => []], JSON_THROW_ON_ERROR) ?>'></i>
                    </div>
                    <div class="refs-block special" id="end-section">
                        <div>
                            <p class="block-title"><?= __('End section') ?></p>
                            <small><?= __('Constructor type') ?></small>
                        </div>
                        <i class="fa-solid fa-circle-plus fa-lg fa-fw new-block" data-json="end" data-title="<?= __('End section') ?>" data-message="<?= __('You can\'t End a section before opening a new one with a Start Section') ?>" data-small="<?= __('Constructor type') ?>" data-info='<?= json_encode(["type" => "constructor"], JSON_THROW_ON_ERROR) ?>'></i>
                    </div>
                    <?php foreach ($json['options'] as $key => $block): ?>
                        <div class="refs-block">
                            <div>
                                <p class="block-title"><?= ucfirst(__($key)) ?> <?= __('block') ?></p>
                                <small><?= ucfirst(__($block['type'] . ' type')) ?></small>
                            </div>
                            <i class="fa-solid fa-circle-plus fa-lg fa-fw new-block" data-json="<?= $key ?>" data-title="<?= ucfirst(__($key)) ?> <?= __('block') ?>" data-small="<?= ucfirst(__($block['type'] . ' type')) ?>" data-info='<?= json_encode($block, JSON_THROW_ON_ERROR) ?>'></i>
                        </div>
                    <?php endforeach; ?>
                </div>
                <div id="form-editor" class="sub-form-editor xLarge-6 large-6 medium-12 small-12 xSmall-12">
                    <div class="build-block" id="last-block">
                        <i><?= __('Add new block') ?></i>
                    </div>
                </div>
            </div>
        <?php return ob_get_clean();
    }
}

if (!function_exists('fieldsConstructor')) {

    function fieldsConstructor($row): string
    {
        $content = '';
        $others = ['autre', 'autres', 'other', 'others', '?'];
        $name = \Str::slug($row->label);

        if ($row->type === 'checkbox') {

            ob_start(); ?>
                <span class="multiple-inputs">
                    <?php foreach ($row->options as $key => $option): ?>
                        <label class="multi-container">
                            <input type="checkbox" name="<?= $name ?>[]" value="<?= $key ?>">
                            <span><?= (in_array($option, $others, true)) ? __('Other') : $option ?></span>
                            <?php if (in_array($option, $others, true)): ?>
                                <textarea class="other-text" name="<?= $name ?>-text"></textarea>
                            <?php endif; ?>
                        </label>
                    <?php endforeach; ?>
                </span>
            <?php $content = ob_get_clean();

        } else if ($row->type === 'radio') {

            ob_start(); $cnt = 0; ?>
                <span class="multiple-inputs">
                    <?php foreach ($row->options as $key => $option): ?>
                        <label class="multi-container">
                            <input type="radio" name="<?= $name ?>" value="<?= $key ?>">
                            <span><?= (in_array($option, $others, true)) ? __('Other') : $option ?></span>
                            <?php if (in_array($option, $others, true)): ?>
                                <textarea class="other-text" name="<?= $name ?>-text"></textarea>
                            <?php endif; ?>
                        </label>
                    <?php endforeach; ?>
                </span>
            <?php $content = ob_get_clean();

        } else if ($row->type === 'number') {

            ob_start(); ?>
                <input type="number" name="<?= $name ?>">
            <?php $content = ob_get_clean();

        } else if ($row->type === 'select') {

            ob_start(); ?>
            <select name="<?= $name ?>">
                <?php foreach ($row->options as $option): ?>
                    <option value="<?= $option ?>"><?= $option ?></option>
                <?php endforeach; ?>
            </select>
            <?php $content = ob_get_clean();

        } else if ($row->type === 'text') {

            ob_start(); ?>
            <input type="text" spellcheck="false" autocomplete="off" name="<?= $name ?>">
            <?php $content = ob_get_clean();

        } else if ($row->type === 'textarea') {

            ob_start(); ?>
            <?php if ($row->editable === true): ?>
                <textarea spellcheck="false" autocomplete="off" name="<?= $name ?>"></textarea>
            <?php else: ?>
                <i style="font-style: italic;" class="textarea option-area"><?= $row->content ?></i>
            <?php endif; ?>
            <?php $content = ob_get_clean();

        } else if ($row->type === 'file') {

            ob_start(); ?>
            <input type="file" name="<?= $name ?>[]" multiple accept="image/*">
            <?php $content = ob_get_clean();
        }

        return $content;
    }
}

if (!function_exists('getForm')) {

    /**
     * @throws JsonException
     */
    function getForm($data): string
    {
        $form = json_decode($data, false, 512, JSON_THROW_ON_ERROR);
        ob_start(); ?>
        <div class="form-constructor">
            <div class="no-print infos">
                <i><?= ucfirst($form->header) ?> header</i>
                <i>Main render : <?= ucfirst($form->main->format) ?></i>
                <i><?= ucfirst($form->footer) ?> footer</i>
            </div>
            <?php foreach ($form->main->content as $row): ?>
                <?php $row = json_decode($row, false, 512, JSON_THROW_ON_ERROR) ?>
                <?php if($row->title === 'Start section'): ?>
                    <?php if (trim($row->label) !== ''): ?>
                        <fieldset>
                            <legend><?= $row->label ?></legend>
                    <?php else: ?>
                        <div class="fieldset">
                    <?php endif; ?>
                <?php elseif($row->title === 'End section'): ?>
                    <?php if (trim($row->label) !== ''): ?>
                        </fieldset>
                    <?php else: ?>
                        </div>
                    <?php endif; ?>
                <?php else: ?>
                    <div class="form-control">
                        <?php if (trim($row->label) !== ''): ?>
                        <span>
                            <?= $row->label ?>
                            <?php if(isset($row->unit) && $row->unit !== ''): ?>
                                <i>(<?= $row->unit ?>)</i>
                            <?php endif; ?>
                        </span>
                        <?php endif; ?>
                        <?= fieldsConstructor($row) ?>
                    </div>
                <?php endif; ?>
            <?php endforeach; ?>
        </div>
        <?php return ob_get_clean();
    }
}

if (!function_exists('categoriesSchema')) {

    function categoriesSchema(?int $id = null, bool $rec = false): array {

        $schema = [];
        if ($rec === false) {
            $cats = ($id === null)
                ? Category::select('id', 'name')->where('name', '!=', 'None')->where('parent', 1)->get()
                : Category::select('id', 'name')->where('id', $id)->where('name', '!=', 'None')->first();
        } else {
            $cats = Category::select('id', 'name')->where('parent', $id)->where('name', '!=', 'None')->get();
        }
        if ($id === null) {
            foreach ($cats as $cat) {
                $schema[] = ['name' => $cat->name, 'id' => $cat->id, 'children' => categoriesSchema((int) $cat->id, true)];
            }
        } else if ($cats !== null) {
            if ($rec === false) {
                $schema[] = ['name' => $cats->name, 'id' => $cats->id, 'children' => categoriesSchema((int)$cats->id, true)];
            } else {
                foreach ($cats as $cat) {
                    $schema[] = ['name' => $cat->name, 'id' => $cat->id, 'children' => categoriesSchema((int) $cat->id, true)];
                }
            }
        }

        return $schema;
    }
}

if (!function_exists('categoriesToHTML')) {
    
    function categoriesToHTML(array $cats, string $html = ''): string
    {
        ob_start(); ?>
        <ul class="">
            <?php foreach ($cats as $cat): ?>
            <li>
                <a href="<?= route('categories.show', ['category' => $cat['id']]) ?>">
                    <i class="fa-solid fa-tag fa-lg fa-fw"></i>
                    <?= $cat['name'] ?>
                </a>
                <?php if (!empty($cat['children'])): ?>
                <?= categoriesToHTML($cat['children']) ?>
                <?php endif; ?>
            </li>
            <?php endforeach; ?>
        </ul>
        <?php $html .=ob_get_clean();
        return $html;
    }
}

if (!function_exists('getCategories')) {

    function getCategories(?int $id = null): string
    {
        ob_start(); ?>
        <div class="relations-widget">
            <h4 class="form-title"><?= __('Categories tree') ?></h4>
            <div class="categories-tree-container">
            <?php if ($id === null): ?>
                <?= categoriesToHTML(categoriesSchema()) ?>
            <?php else: ?>
                <?= categoriesToHTML(categoriesSchema($id)) ?>
            <?php endif; ?>
            </div>
        </div>
        <?php return ob_get_clean();
    }
}

if (!function_exists('formatForm')) {

    function formatForm($data): string
    {
        ob_start(); ?>
        <ul>
            <?php foreach ($data as $key => $value): ?>
                <li><b><?= $key ?> : </b><?= $value ?></li>
            <?php endforeach; ?>
        </ul>
        <?php return ob_get_clean();
    }
}

if (!function_exists('formatMission')) {

    function formatMission($data): string
    {
        ob_start(); ?>
        <ul>
            <?php foreach ($data as $key => $value): ?>
                <li><b><?= $key ?> : </b><?= $value ?></li>
            <?php endforeach; ?>
        </ul>
        <?php return ob_get_clean();
    }
}