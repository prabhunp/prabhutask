<?php

namespace App\Model\Repositories\Interfaces;

/**
 * This interface is used for providing all messages of application
 */
interface IMessages
{
    /**
     * Error message object_is_required.
     *
     * @var string
     */
    const MSG_OBJECT_IS_REQUIRED = 1;

    /**
     * Error message object_is_invalid.
     *
     * @var string
     */
    const MSG_OBJECT_IS_INVALID = 2;

    /**
     * Error message object_not_found.
     *
     * @var string
     */
    const MSG_OBJECT_NOT_FOUND = 3;

    /**
     * Error message object_does_not_exist.
     *
     * @var string
     */
    const MSG_OBJECT_DOES_NOT_EXIST = 4;

    /**
     * Message object_was_deleted.
     *
     * @var string
     */
    const MSG_OBJECT_WAS_DELETED = 5;

    /**
     * Error message user_did_not_owner_this_object.
     *
     * @var string
     */
    const MSG_USER_DID_NOT_OWNER_THIS_OBJECT = 6;

    /**
     * Error message user_can_not_delete_object.
     *
     * @var string
     */
    const MSG_USER_CAN_NOT_DELETE_OBJECT = 7;

    /**
     * Error message the_field_is_required.
     *
     * @var string
     */
    const MSG_THE_FIELD_IS_REQUIRED = 8;

    /**
     * Error message the_field_is_invalid.
     *
     * @var string
     */
    const MSG_THE_FIELD_IS_INVALID = 9;

    /**
     * Error message active_tournament_not_found.
     *
     * @var string
     */
    const MSG_ACTIVE_TOURNAMENT_NOT_FOUND = 10;

    /**
     * @var string
     */
    const MSG_YOU_ALREADY_HAVE_A_DYNAMIC_BRACKET = 11;

    /**
     * Error message user_already_joined_pool.
     *
     * @var string
     */
    const MSG_USER_ALREADY_JOINED_POOL = 12;

    /**
     * Error message account_is_available_to_register.
     *
     * @var string
     */
    const MSG_ACCOUNT_IS_AVAILABLE_TO_REGISTER = 13;

    /**
     * Invitation message
     *
     * @var string
     */
    const MSG_POOL_INVITATION_SENT = 14;

    /**
     * Error message invalid_image_format.
     *
     * @var string
     */
    const MSG_INVALID_IMAGE_FORMAT = 15;

    /**
     * Error message check_your_mail_to_reset_password.
     *
     * @var string
     */
    const MSG_CHECK_YOUR_MAIL_TO_RESET_PASSWORD = 16;

    /**
     * Error message no_game_to_pick.
     *
     * @var string
     */
    const MSG_NO_GAME_TO_PICK = 17;

    /**
     * Error message you_can_not_action_at_this_time.
     *
     * @var string
     */
    const MSG_CAN_NOT_PICK_AT_THIS_TIME = 18;
    const MSG_CAN_NOT_ACTION_AT_THIS_TIME = 19;
    const MSG_CAN_NOT_PICK_ON_ENDED_GAME = 20;
    const MSG_DO_NOT_HAVE_DYNAMIC_BRACKET = 21;
    const MSG_TEAM_IS_PICKED_BEFORE = 22;
    const MSG_CAN_NOT_ACTIVE_CLOSED_TOURNAMENT = 23;
    const MSG_TRANSACTION_ALREADY_IN_USED = 24;
	
	const MSG_NO_SWITCH_PICKS	=	25;
	
	const MSG_DO_NOT_HAVE_STATIC_BRACKET	=	26;
}
