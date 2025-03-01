import { gradeColors, statTrakifyName } from '@/lib/utils';
import { ItemGrade, UnboxWithRelations } from '@/types';
import { Button } from './button';
import Icons from './icons';

type Props = {
    unboxedDialogRef: React.RefObject<HTMLDialogElement | null>;
    historyDialogRef: React.RefObject<HTMLDialogElement | null>;
    unbox: UnboxWithRelations | null;
    unlockButtonDisabled: boolean;
    openCaseFunc: (dontOpenDialog?: boolean) => void;
};

export const UnboxedItemDialog = ({ unboxedDialogRef, historyDialogRef, unbox, unlockButtonDisabled, openCaseFunc }: Props) => {
    const itemShareUrl = new URL('https://twitter.com/intent/tweet');
    itemShareUrl.searchParams.set(
        'text',
        `I unboxed a ${statTrakifyName(unbox?.item.name ?? '', unbox?.is_stat_trak ?? false)}${
            unbox?.item.phase ? ` (${unbox?.item.phase})` : ''
        } in the Counter-Strike Case Simulator!\n\nTry here:`,
    );
    itemShareUrl.searchParams.set('url', 'case-sim.com');

    const steamMarketUrl = new URL('https://steamcommunity.com/market/search?appid=730');
    steamMarketUrl.searchParams.set('q', unbox?.item.name ?? '');

    return (
        <dialog
            className="mx-auto w-full max-w-lg border-[1px] border-white/30 bg-[#2d2d2d]/50 text-xl text-white backdrop-blur-xl backdrop:bg-black/30 backdrop:backdrop-blur-sm"
            ref={unboxedDialogRef}
        >
            <div className="flex flex-col">
                <div
                    className="border-b-[12px] bg-[#262626]/70 p-3 text-3xl font-semibold text-neutral-400"
                    style={{
                        borderColor: unbox?.item.name.includes('★') ? gradeColors['Rare Special Item'] : gradeColors[unbox?.item.rarity as ItemGrade],
                    }}
                >
                    <span>
                        You got a{' '}
                        <span
                            style={{
                                color: unbox?.item.name.includes('★')
                                    ? gradeColors['Rare Special Item']
                                    : gradeColors[unbox?.item.rarity as ItemGrade],
                            }}
                        >
                            <a href={itemShareUrl.href} target="_blank" title="Share this pull on X / Twitter!">
                                {statTrakifyName(unbox?.item.name ?? '', unbox?.is_stat_trak ?? false)}{' '}
                                {unbox?.item.phase ? ` (${unbox?.item.phase})` : ''}
                            </a>
                        </span>
                    </span>
                </div>

                <div className="flex flex-col p-2">
                    {unbox?.item && (
                        <div key={unbox?.item.id} className="flex justify-center">
                            <img
                                className="block [@media_(max-height:580px)]:hidden"
                                src={unbox?.item.image}
                                alt={`${unbox?.item.name} image`}
                                width={512}
                                height={384}
                                draggable={false}
                            />

                            <img
                                className="hidden [@media_(max-height:580px)]:block"
                                src={unbox?.item.image}
                                alt={`${unbox?.item.name} image`}
                                width={512 / 2.7}
                                height={384 / 2.7}
                                draggable={false}
                            />
                        </div>
                    )}

                    <div className="flex flex-wrap justify-end gap-1">
                        <Button variant="secondary" href={steamMarketUrl.href} openInNewTab className="mr-auto flex items-center">
                            <Icons.steam className="size-7" />
                        </Button>

                        <Button variant="secondary" onClick={() => unboxedDialogRef.current?.close()}>
                            CLOSE
                        </Button>

                        <Button variant="secondary" onClick={() => historyDialogRef.current?.showModal()}>
                            HISTORY
                        </Button>

                        <Button variant="primary" disabled={unlockButtonDisabled} playSoundOnClick={false} onClick={() => openCaseFunc(true)}>
                            RETRY
                        </Button>
                    </div>
                </div>
            </div>
        </dialog>
    );
};
