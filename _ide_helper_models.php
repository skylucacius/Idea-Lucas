<?php

// @formatter:off
// phpcs:ignoreFile
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
/**
 * @property int $id
 * @property int $user_id
 * @property string $title
 * @property string|null $image_path
 * @property string|null $description
 * @property \App\Enums\IdeaStatus $status
 * @property \Illuminate\Database\Eloquent\Casts\ArrayObject<array-key, mixed> $links
 * @property \Carbon\CarbonImmutable|null $created_at
 * @property \Carbon\CarbonImmutable|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Step> $steps
 * @property-read int|null $steps_count
 * @property-read \App\Models\User $user
 * @method static \Database\Factories\IdeaFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Idea newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Idea newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Idea query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Idea whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Idea whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Idea whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Idea whereImagePath($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Idea whereLinks($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Idea whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Idea whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Idea whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Idea whereUserId($value)
 */
	class Idea extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property bool $completed
 * @property int $idea_id
 * @property \Carbon\CarbonImmutable|null $created_at
 * @property \Carbon\CarbonImmutable|null $updated_at
 * @property-read \App\Models\Idea $idea
 * @method static \Database\Factories\StepFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Step newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Step newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Step query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Step whereCompleted($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Step whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Step whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Step whereIdeaId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Step whereUpdatedAt($value)
 */
	class Step extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $name
 * @property string $email
 * @property Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $two_factor_secret
 * @property string|null $two_factor_recovery_codes
 * @property Carbon|null $two_factor_confirmed_at
 * @property string|null $remember_token
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Idea> $ideas
 * @property-read int|null $ideas_count
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @method static \Database\Factories\UserFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereUpdatedAt($value)
 */
	class User extends \Eloquent {}
}

