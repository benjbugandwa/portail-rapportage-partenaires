<?php

namespace App\Livewire\Admin\Users;

use Livewire\Component;
use App\Models\User;
use App\Models\LoginLog;
use Livewire\Attributes\On;
use Carbon\Carbon;

class UserAuditModal extends Component
{
    public $show = false;
    public $user_id;
    public $nom;
    public $period = '30';
    public $login_count = 0;
    public $activities_count = 0;

    #[On('audit-user')]
    public function loadAudit($id)
    {
        $user = User::findOrFail($id);
        $this->user_id = $user->id;
        $this->nom = $user->nom;
        
        $this->calculateStats();
        $this->show = true;
    }

    public function calculateStats()
    {
        $startDate = Carbon::now()->subDays((int)$this->period);

        $this->login_count = LoginLog::where('user_id', $this->user_id)
            ->where('login_at', '>=', $startDate)
            ->count();

        if (class_exists(\App\Models\Activity::class)) {
            $this->activities_count = \App\Models\Activity::where('created_by', $this->user_id)
                ->where('created_at', '>=', $startDate)
                ->count();
        } else {
            $this->activities_count = 0;
        }
    }

    public function updatedPeriod()
    {
        if ($this->user_id) {
            $this->calculateStats();
        }
    }

    public function close()
    {
        $this->show = false;
    }

    public function render()
    {
        $logs = [];
        if ($this->user_id) {
            $logs = LoginLog::where('user_id', $this->user_id)
                ->orderBy('login_at', 'desc')
                ->limit(5)
                ->get();
        }

        return view('livewire.admin.users.user-audit-modal', [
            'recent_logs' => $logs
        ]);
    }
}
