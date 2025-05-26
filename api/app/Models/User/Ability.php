<?php

namespace App\Models\User;

use Silber\Bouncer\Database\Ability as BouncerAbility;

class Ability extends BouncerAbility
{
    // the excludes value should be an array of user roles (currently just a
    // string of the name). e.g. if the 'manager' and 'coordinator' roles will
    // never have the ability to 'write settings' then the excludes value should
    // be an array that includes the strings of their role names in the array.
    // All it really does though is not show the permission in the list,
    // technically it could still be added as default permission.
    // i.e. 'excludes' => ['manager', 'coordinator']. This will mean the 'write settings'
    // permission will not show in the list of permissions when adjusting a
    // 'manager' or 'coordinator'
    const ABILITIES = [
        'employees' => [
            'read' => ['name' => self::READ_EMPLOYEES, 'excludes' => []],
            'write' => ['name' => self::WRITE_EMPLOYEES, 'excludes' => []],
        ],
        'companies' => [
            'read' => ['name' => self::READ_COMPANY, 'excludes' => []],
            'write' => ['name' => self::WRITE_COMPANY, 'excludes' => []],
        ],
        'users' => [
            'read' => ['name' => self::READ_USERS, 'excludes' => []],
            'write' => ['name' => self::WRITE_USERS, 'excludes' => []],
        ],
        'roles' => [
            'read' => ['name' => self::READ_ROLES, 'excludes' => []],
            'write' => ['name' => self::WRITE_ROLES, 'excludes' => []],
        ],
    ];

    /**
     * Ability constants.
     */
    const READ_EMPLOYEES = 'read employees';
    const WRITE_EMPLOYEES = 'write employees';

    const READ_COMPANY = 'read companies';
    const WRITE_COMPANY = 'write companies';

    const READ_USERS = 'read users';
    const WRITE_USERS = 'write users';

    const READ_ROLES = 'read roles';
    const WRITE_ROLES = 'write roles';

    /**
     * Cached abilities from reflection.
     *
     * @var array|void
     */
    protected static $cache;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'title', 'group', 'excludes'];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'int',
        'entity_id' => 'int',
        'only_owned' => 'boolean',
        'excludes' => 'json',
    ];
}
