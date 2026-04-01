<?php

namespace App\Traits;

use App\Models\Log;
use Illuminate\Support\Facades\Request;

trait LogsActivity
{
    protected static function bootLogsActivity()
    {
        static::created(function ($model) {
            $model->logActivity('created', $model->getAttributes());
        });

        static::updated(function ($model) {
            $changes = $model->getChanges();
            $original = $model->getOriginal();

            $description = [];
            foreach ($changes as $field => $newValue) {
                if ($field !== 'updated_at') {
                    $oldValue = $original[$field] ?? 'null';
                    // Converter arrays para JSON
                    $oldValueFormatted = is_array($oldValue) ? json_encode($oldValue) : $oldValue;
                    $newValueFormatted = is_array($newValue) ? json_encode($newValue) : $newValue;
                    $description[] = "{$field}: {$oldValueFormatted} → {$newValueFormatted}";
                }
            }

            if (!empty($description)) {
                $model->logActivity('updated', implode(', ', $description));
            }
        });

        static::deleted(function ($model) {
            $model->logActivity('deleted', $model->getAttributes());
        });
    }

    public function logActivity($action, $details)
    {
        // Converter $details para string se for array ou objeto
        $detailsString = $this->formatDetails($details);

        Log::create([
            'data_hora' => now(),
            'user_id' => auth()->id(),
            'modulo' => class_basename($this),
            'objeto_id' => $this->id,
            'alteracao' => "{$action}: {$detailsString}",
            'ip' => Request::ip(),
            'browser' => Request::header('User-Agent'),
        ]);
    }

    /**
     * Formata os detalhes para string
     */
    private function formatDetails($details): string
    {
        if (is_string($details)) {
            return $details;
        }

        if (is_array($details)) {
            // Remove campos que não queremos logar
            $filtered = array_filter($details, function($key) {
                return !in_array($key, ['updated_at', 'created_at', 'stripe_checkout_session_id']);
            }, ARRAY_FILTER_USE_KEY);

            // Formata o array como string legível
            $formatted = [];
            foreach ($filtered as $key => $value) {
                if (is_array($value)) {
                    $formatted[] = "{$key}: " . json_encode($value);
                } else {
                    $formatted[] = "{$key}: {$value}";
                }
            }
            return implode(', ', $formatted);
        }

        if (is_object($details)) {
            return json_encode($details);
        }

        return (string) $details;
    }
}
