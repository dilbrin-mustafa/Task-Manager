<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\DB;

class Task extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'priority', 'project_id'];

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    /**
     * Get tasks for a given project, ordered by priority.
     */
    public static function forProject(int $projectId)
    {
        return self::where('project_id', $projectId)
            ->orderBy('priority')
            ->get();
    }

    /**
     * Create a task and assign it the next priority automatically.
     */
    public static function createWithNextPriority(array $attributes): self
    {
        $attributes['priority'] = self::where('project_id', $attributes['project_id'])
                ->max('priority') + 1;

        return self::create($attributes);
    }

    /**
     * Update the task name.
     */
    public function updateName(string $name): bool
    {
        return $this->update(['name' => $name]);
    }

    /**
     * Reorder tasks based on the given array of IDs.
     */
    public static function reorder(array $taskIds): void
    {
        if (empty($taskIds)) {
            return;
        }

        $cases = [];
        $params = [];

        foreach ($taskIds as $index => $taskId) {
            $priority = $index + 1;
            $cases[] = "WHEN id = ? THEN ?";
            $params[] = $taskId;
            $params[] = $priority;
        }

        $caseSql = implode(' ', $cases);
        $idsSql  = implode(',', array_fill(0, count($taskIds), '?'));

        $params = array_merge($params, $taskIds);

        DB::transaction(function () use ($caseSql, $idsSql, $params) {
            DB::update(
                "UPDATE tasks SET priority = (CASE {$caseSql} END) WHERE id IN ({$idsSql})",
                $params
            );
        });
    }
}
