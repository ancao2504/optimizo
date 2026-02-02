<?php
$data = App\Models\Category::with('tools:id,category_id,slug')->get(['id', 'slug']);
$result = [];
foreach ($data as $c) {
    $result[$c->slug] = $c->tools->pluck('slug')->toArray();
}
file_put_contents('tools_map.json', json_encode($result, JSON_PRETTY_PRINT));
echo "Dumped to tools_map.json";
