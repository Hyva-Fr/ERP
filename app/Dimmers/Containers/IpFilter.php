<?php

namespace App\Dimmers\Containers;

use App\Dimmers\DimmerInterface\RenderInterface;
use App\Models\Ip;
use Carbon\Carbon;

class IpFilter implements RenderInterface
{
    public function index()
    {
        $ips = Ip::orderBy('created_at', 'desc')->get();
        $this->refreshList($ips);
        $data = $this->parseRecords($ips);
        return view('dimmers.containers.ipfilter', compact('data'));
    }

    /**
     * @throws \JsonException
     */
    private function parseRecords($ips): array
    {
        $data = [];
        foreach ($ips as $ip) {

            $original = [];

            $original['id'] = $ip->id;
            $original['attempts'] = (int) $ip->attempts;
            $original['is_ban'] = (int) $ip->is_ban;

            $json = json_decode($ip->data, true, 512, JSON_THROW_ON_ERROR);
            unset($json['driver']);
            $single = array_merge($original, $json);

            $flag = strtolower($single['countryName']) . '.png';
            $flagPath = storage_path() . '/app/public/media/flags/' . $flag;
            $single['flag'] = (file_exists($flagPath))
                ? strtolower($single['countryName']) . '.png'
                : null;

            $single['created_at'] = ($ip->created_at !== null) ? $ip->created_at->isoFormat('lll') : null;
            $single['updated_at'] = ($ip->updated_at !== null) ? $ip->updated_at->isoFormat('lll') : null;

            $data[] = $single;
        }
        return $data;
    }

    private function refreshList($ips): void
    {
        foreach ($ips as $ip) {
            if ($ip->is_ban === 0 && $ip->created_at->diffInDays(Carbon::now()) > 20) {
                Ip::where('id', $ip->id)->delete();
            }
        }
    }
}