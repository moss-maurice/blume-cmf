<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class EventsSeeder extends Seeder
{
    protected $events = [
        'auth.onRegister.before' => \Blume\Events\Auth\OnRegisterBeforeEvent::class,
        'auth.onRegister' => \Blume\Events\Auth\OnRegisterEvent::class,
        'auth.onRegister.after' => \Blume\Events\Auth\OnRegisterAfterEvent::class,
        'auth.onRegister.success' => \Blume\Events\Auth\OnRegisterSuccessEvent::class,
        'auth.onRegister.error' => \Blume\Events\Auth\OnRegisterErrorEvent::class,
        'auth.onLogin.before' => \Blume\Events\Auth\OnLoginBeforeEvent::class,
        'auth.onLogin' => \Blume\Events\Auth\OnLoginEvent::class,
        'auth.onLogin.after' => \Blume\Events\Auth\OnLoginAfterEvent::class,
        'auth.onLogin.success' => \Blume\Events\Auth\OnLoginSuccessEvent::class,
        'auth.onLogin.error' => \Blume\Events\Auth\OnLoginErrorEvent::class,
        'auth.onLogout.before' => \Blume\Events\Auth\OnLogoutBeforeEvent::class,
        'auth.onLogout' => \Blume\Events\Auth\OnLogoutEvent::class,
        'auth.onLogout.after' => \Blume\Events\Auth\OnLogoutAfterEvent::class,
        'auth.onLogout.success' => \Blume\Events\Auth\OnLogoutSuccessEvent::class,
        'auth.onLogout.error' => \Blume\Events\Auth\OnLogoutErrorEvent::class,
        'auth.onPasswordReset.before' => \Blume\Events\Auth\OnPasswordResetBeforeEvent::class,
        'auth.onPasswordReset' => \Blume\Events\Auth\OnPasswordResetEvent::class,
        'auth.onPasswordReset.after' => \Blume\Events\Auth\OnPasswordResetAfterEvent::class,
        'auth.onPasswordReset.success' => \Blume\Events\Auth\OnPasswordResetSuccessEvent::class,
        'auth.onPasswordReset.error' => \Blume\Events\Auth\OnPasswordResetErrorEvent::class,
        'auth.onPasswordResetSendLink.before' => \Blume\Events\Auth\OnPasswordResetSendLinkBeforeEvent::class,
        'auth.onPasswordResetSendLink' => \Blume\Events\Auth\OnPasswordResetSendLinkEvent::class,
        'auth.onPasswordResetSendLink.after' => \Blume\Events\Auth\OnPasswordResetSendLinkAfterEvent::class,
        'auth.onPasswordResetSendLink.success' => \Blume\Events\Auth\OnPasswordResetSendLinkSuccessEvent::class,
        'auth.onPasswordResetSendLink.error' => \Blume\Events\Auth\OnPasswordResetSendLinkErrorEvent::class,

        'plugin.onInstall.before' => \Blume\Events\Plugins\OnInstallBeforeEvent::class,
        'plugin.onInstall' => \Blume\Events\Plugins\OnInstallEvent::class,
        'plugin.onInstall.after' => \Blume\Events\Plugins\OnInstallAfterEvent::class,
        'plugin.onInstall.success' => \Blume\Events\Plugins\OnInstallSuccessEvent::class,
        'plugin.onInstall.error' => \Blume\Events\Plugins\OnInstallErrorEvent::class,
        'plugin.onUninstall.before' => \Blume\Events\Plugins\OnUninstallBeforeEvent::class,
        'plugin.onUninstall' => \Blume\Events\Plugins\OnUninstallEvent::class,
        'plugin.onUninstall.after' => \Blume\Events\Plugins\OnUninstallAfterEvent::class,
        'plugin.onUninstall.success' => \Blume\Events\Plugins\OnUninstallSuccessEvent::class,
        'plugin.onUninstall.error' => \Blume\Events\Plugins\OnUninstallErrorEvent::class,
        'plugin.onActivate.before' => \Blume\Events\Plugins\OnActivateBeforeEvent::class,
        'plugin.onActivate' => \Blume\Events\Plugins\OnActivateEvent::class,
        'plugin.onActivate.after' => \Blume\Events\Plugins\OnActivateAfterEvent::class,
        'plugin.onActivate.success' => \Blume\Events\Plugins\OnActivateSuccessEvent::class,
        'plugin.onActivate.error' => \Blume\Events\Plugins\OnActivateErrorEvent::class,
        'plugin.onDeactivate.before' => \Blume\Events\Plugins\OnDeactivateBeforeEvent::class,
        'plugin.onDeactivate' => \Blume\Events\Plugins\OnDeactivateEvent::class,
        'plugin.onDeactivate.after' => \Blume\Events\Plugins\OnDeactivateAfterEvent::class,
        'plugin.onDeactivate.success' => \Blume\Events\Plugins\OnDeactivateSuccessEvent::class,
        'plugin.onDeactivate.error' => \Blume\Events\Plugins\OnDeactivateErrorEvent::class,
        'plugin.onRegister.before' => \Blume\Events\Plugins\OnRegisterBeforeEvent::class,
        'plugin.onRegister' => \Blume\Events\Plugins\OnRegisterEvent::class,
        'plugin.onRegister.after' => \Blume\Events\Plugins\OnRegisterAfterEvent::class,
        'plugin.onRegister.success' => \Blume\Events\Plugins\OnRegisterSuccessEvent::class,
        'plugin.onRegister.error' => \Blume\Events\Plugins\OnRegisterErrorEvent::class,
        'plugin.onUnregister.before' => \Blume\Events\Plugins\OnUnregisterBeforeEvent::class,
        'plugin.onUnregister' => \Blume\Events\Plugins\OnUnregisterEvent::class,
        'plugin.onUnregister.after' => \Blume\Events\Plugins\OnUnregisterAfterEvent::class,
        'plugin.onUnregister.success' => \Blume\Events\Plugins\OnUnregisterSuccessEvent::class,
        'plugin.onUnregister.error' => \Blume\Events\Plugins\OnUnregisterErrorEvent::class,

        'event.onRegisterEvent.before' => \Blume\Events\Events\OnRegisterEventBeforeEvent::class,
        'event.onRegisterEvent' => \Blume\Events\Events\OnRegisterEventEvent::class,
        'event.onRegisterEvent.after' => \Blume\Events\Events\OnRegisterEventAfterEvent::class,
        'event.onRegisterEvent.success' => \Blume\Events\Events\OnRegisterEventSuccessEvent::class,
        'event.onRegisterEvent.error' => \Blume\Events\Events\OnRegisterEventErrorEvent::class,
        'event.onUnregisterEvent.before' => \Blume\Events\Events\OnUnregisterEventBeforeEvent::class,
        'event.onUnregisterEvent' => \Blume\Events\Events\OnUnregisterEventEvent::class,
        'event.onUnregisterEvent.after' => \Blume\Events\Events\OnUnregisterEventAfterEvent::class,
        'event.onUnregisterEvent.success' => \Blume\Events\Events\OnUnregisterEventSuccessEvent::class,
        'event.onUnregisterEvent.error' => \Blume\Events\Events\OnUnregisterEventErrorEvent::class,
        'event.onCallEvent.before' => \Blume\Events\Events\OnCallEventBeforeEvent::class,
        'event.onCallEvent' => \Blume\Events\Events\OnCallEventEvent::class,
        'event.onCallEvent.after' => \Blume\Events\Events\OnCallEventAfterEvent::class,
        'event.onCallEvent.success' => \Blume\Events\Events\OnCallEventSuccessEvent::class,
        'event.onCallEvent.error' => \Blume\Events\Events\OnCallEventErrorEvent::class,
        'event.onRegisterListener.before' => \Blume\Events\Events\OnRegisterListenerBeforeEvent::class,
        'event.onRegisterListener' => \Blume\Events\Events\OnRegisterListenerEvent::class,
        'event.onRegisterListener.after' => \Blume\Events\Events\OnRegisterListenerAfterEvent::class,
        'event.onRegisterListener.success' => \Blume\Events\Events\OnRegisterListenerSuccessEvent::class,
        'event.onRegisterListener.error' => \Blume\Events\Events\OnRegisterListenerErrorEvent::class,
        'event.onUnregisterListener.before' => \Blume\Events\Events\OnUnregisterListenerBeforeEvent::class,
        'event.onUnregisterListener' => \Blume\Events\Events\OnUnregisterListenerEvent::class,
        'event.onUnregisterListener.after' => \Blume\Events\Events\OnUnregisterListenerAfterEvent::class,
        'event.onUnregisterListener.success' => \Blume\Events\Events\OnUnregisterListenerSuccessEvent::class,
        'event.onUnregisterListener.error' => \Blume\Events\Events\OnUnregisterListenerErrorEvent::class,
    ];

    public function run()
    {
        collect($this->events)->each(function ($event, $eventName) {
            if (!blume()->events()->isRegisteredEvent($event)) {
                blume()->events()->registerEvent($event, $eventName);
            }
        });
    }
}
