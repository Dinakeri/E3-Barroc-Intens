<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Warning extends Model
{
    protected $fillable = [
        'type',
        'title',
        'message',
        'severity',
        'related_id',
        'related_type',
        'is_resolved',
        'resolved_at',
    ];

    protected $casts = [
        'is_resolved' => 'boolean',
        'resolved_at' => 'datetime',
    ];

    /**
     * Get all unresolved warnings
     */
    public static function unresolved()
    {
        return static::where('is_resolved', false);
    }

    /**
     * Get warnings by type
     */
    public static function byType(string $type)
    {
        return static::where('type', $type);
    }

    /**
     * Mark warning as resolved
     */
    public function resolve()
    {
        $this->update([
            'is_resolved' => true,
            'resolved_at' => now(),
        ]);
    }
}
