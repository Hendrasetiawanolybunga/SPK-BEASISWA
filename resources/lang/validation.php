    <?php

    return [
        /*
        |--------------------------------------------------------------------------
        | Validation Language Lines
        |--------------------------------------------------------------------------
        |
        | The following language lines contain the default error messages used by
        | the validator class. Some of these rules have multiple versions such
        | as the size rules. Feel free to tweak each of these messages here.
        |
        */

        'accepted' => 'Atribut :attribute harus diterima.',
        'active_url' => 'Atribut :attribute bukan URL yang valid.',
        'after' => 'Atribut :attribute harus tanggal setelah :date.',
        'after_or_equal' => 'Atribut :attribute harus tanggal setelah atau sama dengan :date.',
        'alpha' => 'Atribut :attribute hanya boleh berisi huruf.',
        'alpha_dash' => 'Atribut :attribute hanya boleh berisi huruf, angka, tanda hubung, dan garis bawah.',
        'alpha_num' => 'Atribut :attribute hanya boleh berisi huruf dan angka.',
        'array' => 'Atribut :attribute harus berupa array.',
        'before' => 'Atribut :attribute harus tanggal sebelum :date.',
        'before_or_equal' => 'Atribut :attribute harus tanggal sebelum atau sama dengan :date.',
        'between' => [
            'array' => 'Atribut :attribute harus memiliki antara :min dan :max item.',
            'file' => 'Atribut :attribute harus antara :min dan :max kilobyte.',
            'numeric' => 'Atribut :attribute harus antara :min dan :max.',
            'string' => 'Atribut :attribute harus antara :min dan :max karakter.',
        ],
        'boolean' => 'Bidang :attribute harus berupa true atau false.',
        'confirmed' => 'Konfirmasi :attribute tidak cocok.', // Ini yang paling penting untuk "new_password"
        'date' => 'Atribut :attribute bukan tanggal yang valid.',
        'date_equals' => 'Atribut :attribute harus tanggal yang sama dengan :date.',
        'date_format' => 'Atribut :attribute tidak cocok dengan format :format.',
        'different' => 'Atribut :attribute dan :other harus berbeda.',
        'digits' => 'Atribut :attribute harus :digits digit.',
        'digits_between' => 'Atribut :attribute harus antara :min dan :max digit.',
        'dimensions' => 'Atribut :attribute memiliki dimensi gambar yang tidak valid.',
        'distinct' => 'Bidang :attribute memiliki nilai duplikat.',
        'email' => 'Atribut :attribute harus berupa alamat email yang valid.',
        'ends_with' => 'Atribut :attribute harus diakhiri dengan salah satu dari berikut ini: :values.',
        'exists' => 'Atribut :attribute yang dipilih tidak valid.',
        'file' => 'Atribut :attribute harus berupa file.',
        'filled' => 'Bidang :attribute harus memiliki nilai.',
        'gt' => [
            'array' => 'Atribut :attribute harus memiliki lebih dari :value item.',
            'file' => 'Atribut :attribute harus lebih besar dari :value kilobyte.',
            'numeric' => 'Atribut :attribute harus lebih besar dari :value.',
            'string' => 'Atribut :attribute harus lebih besar dari :value karakter.',
        ],
        'gte' => [
            'array' => 'Atribut :attribute harus memiliki :value item atau lebih.',
            'file' => 'Atribut :attribute harus lebih besar dari atau sama dengan :value kilobyte.',
            'numeric' => 'Atribut :attribute harus lebih besar dari atau sama dengan :value.',
            'string' => 'Atribut :attribute harus lebih besar dari atau sama dengan :value karakter.',
        ],
        'image' => 'Atribut :attribute harus berupa gambar.',
        'in' => 'Atribut :attribute yang dipilih tidak valid.',
        'in_array' => 'Bidang :attribute tidak ada di :other.',
        'integer' => 'Atribut :attribute harus berupa bilangan bulat.',
        'ip' => 'Atribut :attribute harus berupa alamat IP yang valid.',
        'ipv4' => 'Atribut :attribute harus berupa alamat IPv4 yang valid.',
        'ipv6' => 'Atribut :attribute harus berupa alamat IPv6 yang valid.',
        'json' => 'Atribut :attribute harus berupa string JSON yang valid.',
        'lt' => [
            'array' => 'Atribut :attribute harus memiliki kurang dari :value item.',
            'file' => 'Atribut :attribute harus kurang dari :value kilobyte.',
            'numeric' => 'Atribut :attribute harus kurang dari :value.',
            'string' => 'Atribut :attribute harus kurang dari :value karakter.',
        ],
        'lte' => [
            'array' => 'Atribut :attribute tidak boleh memiliki lebih dari :value item.',
            'file' => 'Atribut :attribute harus kurang dari atau sama dengan :value kilobyte.',
            'numeric' => 'Atribut :attribute harus kurang dari atau sama dengan :value.',
            'string' => 'Atribut :attribute harus kurang dari atau sama dengan :value karakter.',
        ],
        'max' => [
            'array' => 'Atribut :attribute tidak boleh memiliki lebih dari :max item.',
            'file' => 'Atribut :attribute tidak boleh lebih besar dari :max kilobyte.',
            'numeric' => 'Atribut :attribute tidak boleh lebih besar dari :max.',
            'string' => 'Atribut :attribute tidak boleh lebih besar dari :max karakter.',
        ],
        'mimes' => 'Atribut :attribute harus berupa file dengan tipe: :values.',
        'mimetypes' => 'Atribut :attribute harus berupa file dengan tipe: :values.',
        'min' => [
            'array' => 'Atribut :attribute harus memiliki setidaknya :min item.',
            'file' => 'Atribut :attribute harus setidaknya :min kilobyte.',
            'numeric' => 'Atribut :attribute harus setidaknya :min.',
            'string' => 'Atribut :attribute harus setidaknya :min karakter.',
        ],
        'not_in' => 'Atribut :attribute yang dipilih tidak valid.',
        'not_regex' => 'Format atribut :attribute tidak valid.',
        'numeric' => 'Atribut :attribute harus berupa angka.',
        'present' => 'Bidang :attribute harus ada.',
        'regex' => 'Format atribut :attribute tidak valid.',
        'required' => 'Bidang :attribute wajib diisi.',
        'required_if' => 'Bidang :attribute wajib diisi ketika :other adalah :value.',
        'required_unless' => 'Bidang :attribute wajib diisi kecuali :other ada di :values.',
        'required_with' => 'Bidang :attribute wajib diisi ketika :values ada.',
        'required_with_all' => 'Bidang :attribute wajib diisi ketika :values ada.',
        'required_without' => 'Bidang :attribute wajib diisi ketika :values tidak ada.',
        'required_without_all' => 'Bidang :attribute wajib diisi ketika tidak ada :values yang ada.',
        'same' => 'Atribut :attribute dan :other harus cocok.',
        'size' => [
            'array' => 'Atribut :attribute harus berisi :size item.',
            'file' => 'Atribut :attribute harus :size kilobyte.',
            'numeric' => 'Atribut :attribute harus :size.',
            'string' => 'Atribut :attribute harus :size karakter.',
        ],
        'starts_with' => 'Atribut :attribute harus dimulai dengan salah satu dari berikut ini: :values.',
        'string' => 'Atribut :attribute harus berupa string.',
        'timezone' => 'Atribut :attribute harus berupa zona waktu yang valid.',
        'unique' => 'Atribut :attribute sudah ada.',
        'uploaded' => 'Atribut :attribute gagal diunggah.',
        'url' => 'Format atribut :attribute tidak valid.',
        'uuid' => 'Atribut :attribute harus berupa UUID yang valid.',

        /*
        |--------------------------------------------------------------------------
        | Custom Validation Language Lines
        |--------------------------------------------------------------------------
        |
        | Here you may specify custom validation messages for attributes using the
        | convention "attribute.rule" to name the lines. This makes it quick to
        | specify a specific custom language line for a given attribute rule.
        |
        */

        'custom' => [
            'new_password' => [
                'confirmed' => 'Konfirmasi password baru tidak cocok.',
            ],
            'current_password' => [
                'required' => 'Password saat ini wajib diisi.',
            ],
            // Anda bisa menambahkan pesan kustom lain di sini
        ],

        /*
        |--------------------------------------------------------------------------
        | Custom Validation Attributes
        |--------------------------------------------------------------------------
        |
        | The following language lines are used to swap our attribute placeholder
        | with something more reader friendly such as "E-Mail Address" instead
        | of "email". This simply helps us make messages a little cleaner.
        |
        */

        'attributes' => [
            'current_password' => 'password saat ini',
            'new_password' => 'password baru',
            'new_password_confirmation' => 'konfirmasi password baru',
            'username' => 'username',
            'password' => 'password',
        ],
    ];
    