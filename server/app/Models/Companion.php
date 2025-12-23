<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Companion extends Model
{
    use HasFactory;

    protected $fillable = [
        'patient_id',
        'companion_id',
        'relationship',
        'permissions',
        'status',
        'invitation_token',
        'invitation_sent_at',
        'invitation_accepted_at',
    ];

    protected $casts = [
        'permissions' => 'array',
        'invitation_sent_at' => 'datetime',
        'invitation_accepted_at' => 'datetime',
    ];

    /**
     * Get the patient (the one being cared for)
     */
    public function patient(): BelongsTo
    {
        return $this->belongsTo(User::class, 'patient_id');
    }

    /**
     * Get the companion (the one providing care)
     */
    public function companion(): BelongsTo
    {
        return $this->belongsTo(User::class, 'companion_id');
    }

    /**
     * Check if companion has a specific permission
     */
    public function hasPermission(string $permission): bool
    {
        if (!$this->permissions) {
            return false;
        }

        return in_array($permission, $this->permissions);
    }

    /**
     * Scope for accepted companions only
     */
    public function scopeAccepted($query)
    {
        return $query->where('status', 'accepted');
    }

    /**
     * Scope for pending invitations
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }
}
