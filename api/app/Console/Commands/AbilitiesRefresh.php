<?php

namespace App\Console\Commands;

use Bouncer;
use App\Support\Enums\Role;
use Illuminate\Support\Str;
use App\Models\User\Ability;
use Illuminate\Console\Command;
use Illuminate\Support\Collection;
use Silber\Bouncer\Database\Role as BouncerRole;

class AbilitiesRefresh extends Command
{
    protected $signature = 'abilities:refresh
                            {--C|clean : Cleans dangling abilities that have been removed from the system}
                            {--no-confirmation : Do not require confirmation when cleaning dangling abilities}';

    protected $description = 'Non-destructive refresh of the systems roles/abilities';

    protected $abilities;

        /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();

        $this->abilities = new Collection;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->createAbilities();

        // Create admin role.
        $this->assignAbilitiesToRole($this->createRole(Role::Admin),
            // the default unchangeable abilities for this role
            Ability::all()->pluck('name')->toArray()
        );

        // Create user role.
        $this->assignAbilitiesToRole($this->createRole(Role::User), [
            // the default unchangeable abilities for this role
            Ability::READ_EMPLOYEES,
            Ability::READ_COMPANY,
        ]);

        $this->info('Roles created and abilities assigned.');

        if ($this->option('clean')) {
            $this->cleanAbilities();
        }
    }

    /**
     * Assign abilities to a Bouncer role.
     *
     * @param \Silber\Bouncer\Database\Role $role
     * @param array $abilities
     * @return void
     */
    protected function assignAbilitiesToRole(BouncerRole $role, array $abilities): void
    {
        $abilities = Bouncer::ability()->whereIn('name', $abilities)->get();

        // Remove abilities existing on the role but not in the assigning abilities array.
        $role->disallow($role->abilities->diff($abilities));

        $role->allow($abilities);
    }

    /**
     * Create a Bouncer role in the database or return an existing role.
     *
     * @param \App\Support\Enums\Role $role
     * @return \Silber\Bouncer\Database\Role
     */
    protected function createRole(Role $role): BouncerRole
    {
        return tap(
            Bouncer::role()->firstOrNew(['name' => $role->value]),
            fn (BouncerRole $model) => $model->forceFill([
                'title' => $role->title(),
            ])->save()
        );
    }

    /**
     * Create the abilities.
     *
     * @return void
     */
    protected function createAbilities(): void
    {
        // Create the read/write abilities.
        // Abilities are now grabbed from the array on the Ability model
        collect(Ability::ABILITIES)->each(function ($abilities, $group) {
            collect($abilities)->each(function ($ability, $key) use ($group) {
                $a = Ability::firstOrNew([
                    'name' => Str::lower($ability['name']),
                    'title' => Str::title($key),
                    'group' => $group
                ]);

                $a->excludes = $ability['excludes'];
                $a->save();
            });
        });

        $this->info('Abilities created.');
    }

    /**
     * Clean dangling abilities that are no longer being used by any user/role.
     *
     * Only applies to abilities that have no entity.
     *
     * @return void
     */
    protected function cleanAbilities(): void
    {
        $this->line('');
        $this->warn('! Cleaning dangling simple abilities that are no longer defined.');

        if ($this->option('no-confirmation') === false) {
            $this->warn('! You will be prompted for each ability for confirmation.');
        }

        $this->line('');

        Bouncer::ability()
            ->simpleAbility()
            ->get()

            // Doing a diff against the abilities we found/created will return us the ones that are no
            // longer being defined and have therefore been removed.
            ->diff($this->abilities)
            ->each(function ($ability) {
                $this->line(sprintf('<fg=yellow>[%s]:</> %s users and %s roles associated with ability.', $ability->name, $ability->users()->count(), $ability->roles()->count()));

                if ($this->option('no-confirmation') || $this->confirm('Would you like to detach users/roles and delete this ability?')) {
                    $ability->users()->detach();
                    $ability->roles()->detach();
                    $ability->delete();
                }
            });

        $this->info('Abilities cleaned!');
    }
}