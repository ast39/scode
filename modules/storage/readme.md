## Storage module manual

---
##### Include
    use modules\storage\Storage;
---

##### Settings
>Open file: modules\storage\cfg.php

    return [
        'test' => 'app.public.test',
    ];
---

##### Check for exist
    Storage::disk('public')->exists('test')
---

##### Get datat from storage
    $data = Storage::disk('public')->get('test')->toText();
---

##### Save data into the storage
    Storage::disk('public')->put('test', json_encode(['name' => 'John', 'surname'=> 'Smith']));
---

##### Append data into the storage
    Storage::disk('public')->append('test', json_encode(['name' => 'John', 'surname'=> 'Smith']));
---

##### Delete data from the storage
    Storage::disk('public')->delete('test');
---